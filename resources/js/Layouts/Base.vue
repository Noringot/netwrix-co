<template>
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <header class="header">
            <div class="header__container mx-auto">
                <!-- Logo -->
                <div class="shrink-0 flex items-center md:justify-center">
                    <Link :href="route('partners')">
                      <img src="../../images/logo.png" alt="Netwrix Logo" class="block h-6 w-auto">
                    </Link>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-auto">
            <slot />
        </main>
    </div>
</template>

<script>
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        Link,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        }
    },
}
</script>

<style scoped>

</style>
