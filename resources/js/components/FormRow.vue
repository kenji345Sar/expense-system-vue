<template>
  <div class="border p-4 mb-4 rounded">
    <h3 class="font-semibold mb-2">{{ label }} {{ index + 1 }}</h3>

    <div v-for="field in fields" :key="field.name" class="mb-2">
      <label v-if="field.label" class="block font-medium mb-1">{{ field.label }}</label>

      <input
        v-if="field.type !== 'textarea'"
        :type="field.type"
        class="w-full border rounded p-1"
        :name="`${namespace}[${index}][${field.name}]`"
        v-model="row[field.name]"
        :placeholder="field.placeholder"
      />

      <textarea
        v-else
        class="w-full border rounded p-1"
        :name="`${namespace}[${index}][${field.name}]`"
        v-model="row[field.name]"
        :placeholder="field.placeholder"
      ></textarea>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    index: Number,
    row: Object,
    fields: Array,
    namespace: String,
    label: {
      type: String,
      default: '明細'
    }
  }
}
</script>
