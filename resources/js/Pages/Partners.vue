<template>
  <Head title="Partners"/>
  <BaseLayout>
    <section class="hero bg-hero bg-cover text-center text-white">
      <div class="hero__container md:max-w-[293px] md:mx-auto">
        <h1 class="hero__title text-5xl font-bold mb-2 md:text-[30px] md:leading-[40px] md:mb-6">
          Netwrix Partner Locator
        </h1>
        <p class="hero__description leading-8 mb-12 md:text-[14px] md:leading-[28px]">
          Hundreds of Netwrix partners around the world are standing by to help you.  With our Partner Locator you can easily find the list of authorized partners in your area.
        </p>
        <div class="hero__search mx-auto">
          <Input
            type="search"
            v-model="searchContent"
            class="w-full text-black px-3 py-3 mb-4"
            placeholder="Search .."
          />
          <div class="hero__filter" :key="country">
            <Select
              id="partnerType"
              v-model="partnerType"
              :options="partnerTypes"
              placeholder="Type"
              :key="partnerTypes.length"
              :disabled="false"
            />
            <div class="hero__country flex md:block">
              <Select
                id="countries"
                v-model="country"
                :options="countries"
                placeholder="Country"
                :key="countries.length"
                :disabled="false"
              />
              <Select
                id="states"
                v-model="state"
                :options="states[country]"
                :key="country"
                placeholder="State"
                :disabled="!states[country]?.length"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="partners my-[50px] relative">
      <div :class="{'hidden': !loading}">
        <Loader />
      </div>
      <div class="partners__container container max-w-[1110px] mx-auto flex flex-col md:max-w-[293px] md:mx-auto">
        <div class="partners__pagination flex justify-around flex-wrap md:justify-between md:gap-2">
          <a
            class="partners__page flex justify-center"
            :class="{'partners__page-active': currentPage === index - 1}"
            v-for="index in (totalPages === -1 ? 0 : totalPages)"
            @click.prevent="currentPage = index - 1"
          >{{ index }}</a>
        </div>
        <div
          v-for="partner in paginationPartners"
          class="partners__block mb-[20px] last:mb-0 bg-white"
          :class="{'partners__block--hidden':
          partner.searchFilter || partner.partnerTypeFilter
          || partner.countryFilter || partner.stateFilter }"
          v-if="isListEmpty"
          :key="partner.id"
        >
          <div class="partners__logo">
            <img :src="partner.logo" alt="Logo" class="partners__logo-img md:mb-[35px]">
          </div>

          <div class="partners__text max-w-[390px] ml-10 mr-2 md:m-0 md:mb-[28px]">
            <div class="partners__title font-bold mb-1 md:mb-4">{{ partner.company }}</div>
            <div class="partners__address">{{ partner.address }}</div>
          </div>

          <div class="partners__connect min-w-[150px] mr-10 md:m-0">
            <a :href="partner.website" class="partners__site mb-4 block md:mt-[24px] md:mb-[15px]" target="_blank">Website</a>
            <div class="phone md:mb-[15px]">{{ partner.phone }} </div>
          </div>

          <div class="partners__status">
            <span class="ml-10 md:m-0">{{ partner.status }}</span>
          </div>
        </div>
        <p class="text-center" :class="{'hidden': loading}" v-else>Your search parameters did not match any partners. Please try different search.</p>
      </div>
    </section>
  </BaseLayout>
</template>

<script>
import {Head} from "@inertiajs/inertia-vue3";
import BaseLayout from "@/Layouts/Base";
import Input from "@/Components/Input";
import Select from "@/Components/Select";
import Loader from "../Components/Loader";

export default {
  components: {
    Head,
    BaseLayout,
    Input,
    Select,
    Loader
  },

  beforeMount() {
    axios.get(this.route('get_countries')).then(({data}) => {
      this.countries = data;
    })

    axios.get(this.route('get_states')).then(({data}) => {
      this.states = data;
    })
  },
  mounted() {
    axios.get(this.route('get_partners')).then(({data}) => {
      this.partners = data;
      this.partners.map(partner => {

        partner.searchFilter = this.searchFilter(partner);

        partner.partnerTypeFilter = this.partnerType !== '' &&
          partner.status.toLowerCase() !== this.partnerType.toLowerCase();

        partner.countryFilter = this.country !== '' &&
          !partner.countries_covered?.some(country => country === this.country);

        partner.stateFilter = this.state !== '' &&
          !partner.states_covered?.some(state => state === this.state);
        return partner
      })

      this.loading = false;
    })
  },
  data() {
    return {
      countries: [],
      states: [],
      partners: [],
      loading: true,
      searchContent: '',
      partnerType: '',
      country: '',
      state: '',
      currentPage: 0,
      perPage: 3,
      paginationLinks: 5,
      partnerTypes: [
        {
          value: 'Elite Partner',
          label: 'Elite Partner'
        },
        {
          value: 'Premium Partner',
          label: 'Premium Partner'
        },
        {
          value: 'Distributor',
          label: 'Distributor'
        },
        {
          value: 'MSP Partner',
          label: 'MSP Partner'
        },
        {
          value: 'Preferred Partner',
          label: 'Preferred Partner'
        },
      ]
    }
  },

  methods: {
    searchFilter: function (partner) {
      return !partner.company.toLowerCase().includes(this.searchContent.toLowerCase()) &&
      !partner.address.toLowerCase().includes(this.searchContent.toLowerCase()) &&
      !partner.phone.toLowerCase().includes(this.searchContent.toLowerCase())
    }
  },
  computed: {
    isListEmpty() {
      return this.partners.some(partner => !partner.searchFilter && !partner.partnerTypeFilter &&
        !partner.stateFilter && !partner.countryFilter)
    },
    currentPartners: function () {
      return this.partners.filter(partner => !(partner.searchFilter || partner.partnerTypeFilter
        || partner.countryFilter || partner.stateFilter))
    },
    paginationPartners: function () {
      return this.currentPartners.slice(this.rangeStart, this.rangeEnd)
    },
    rangeStart: function () {
      return this.currentPage * this.perPage;
    },
    rangeEnd: function () {
      return this.currentPage * this.perPage + this.perPage;
    },
    totalPages: function () {
      return Math.floor((this.currentPartners.length - 1) / this.perPage);
    },
  },
  watch: {
    searchContent: function(value) {
      this.loading = true
      this.currentPage = 0;
      this.partners.map(partner => {
        partner.searchFilter = this.searchFilter(partner);
        return partner
      })
      this.loading = false
    },
    partnerType: function(value) {
      this.loading = true
      this.currentPage = 0;
      this.partners.map(partner => {
        partner.partnerTypeFilter = value !== '' && partner.status.toLowerCase() !== value.toLowerCase()
        return partner
      })
      this.loading = false
    },
    country: function(value) {
      this.loading = true
      this.state = ''
      this.currentPage = 0;
      this.partners.map(partner => {
        partner.countryFilter = value !== '' && !partner.countries_covered.some(country => country === value)
        return partner
      })
      this.loading = false
    },
    state: function(value) {
      this.loading = true
      this.currentPage = 0;
      this.partners.map(partner => {
        partner.stateFilter = value !== '' && !partner.states_covered.some(state => state === value)
        return partner
      })
      this.loading = false
    }
  }
}
</script>
