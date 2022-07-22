<template>
  <select v-bind:id="id" class="w-full" :disabled="disabled" :id="id">
    <option v-if="placeholder" value="">{{ placeholder }}</option>
  </select>
</template>

<script>
import BreezeLabel from "@/Components/Label";

export default {
  components: {
    BreezeLabel,
  },
  emits: ["update:modelValue"],
  props: ["modelValue", "id", "options", "placeholder", "disabled"],

    mounted() {
      this.choices = new Choices('#' + this.id, {
        itemSelectText: '',
        allowHTML: true,
      })

        this.choices.setChoices(
          this.options
        );

      this.choices.setChoiceByValue(this.modelValue + '');

      this.choices.passedElement.element.addEventListener('choice', (event) => {
        let value = event.detail.choice.value;
        this.$emit('update:modelValue', value);
      })
    },
    unmounted() {
      // Уничтожаем прошлый выбор
      this.choices.destroy();
    },

  data() {
    return {
      choices: null
    };
  },
};
</script>
