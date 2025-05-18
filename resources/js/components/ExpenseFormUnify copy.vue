<template>
  <div>
    <div
      v-for="(row, index) in rows"
      :key="index"
      class="border p-4 mb-4 rounded"
    >
      <h3 class="font-bold mb-2">{{ formTitle }} {{ index + 1 }}</h3>

      <div
        v-for="field in fields"
        :key="field.name"
        class="mb-2"
      >
        <label class="block mb-1">{{ field.label }}</label>

        <input
          v-if="field.type !== 'textarea'"
          :type="field.type || 'text'"
          class="form-input w-full"
          :name="`${namespace}[${index}][${field.name}]`"
          v-model="rows[index][field.name]"
          :placeholder="field.placeholder"
          :readonly="field.readonly || false"
        />

        <textarea
          v-else
          class="form-input w-full"
          :name="`${namespace}[${index}][${field.name}]`"
          v-model="rows[index][field.name]"
          :placeholder="field.placeholder"
          :readonly="field.readonly || false"
        ></textarea>
      </div>
    </div>

    <div class="mt-4 flex gap-2">
      <button type="button" class="btn-green" @click="checkInput">入力チェック</button>
      <button type="button" class="btn-blue" @click="addRow">＋行を追加</button>
      <button type="button" class="btn-red" @click="removeRow">−行を削除</button>
    </div>

    <input
      type="hidden"
      name="details_json"
      :value="JSON.stringify(rows)"
    />
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  initialItems: {
    type: Array,
    default: () => []
  },
  fields: {
    type: Array,
    required: true
  },
  formTitle: {
    type: String,
    default: ''
  },
  namespace: {
    type: String,
    default: 'details' // フォームで name="details[0][項目]" のように扱う
  }
})

const rows = ref([])

function createEmptyRow() {
  const row = {}
  props.fields.forEach(field => {
    row[field.name] = ''
  })
  return row
}

function addRow() {
  rows.value.push(createEmptyRow())
}

function removeRow() {
  if (rows.value.length > 1) {
    rows.value.pop()
  }
}

function checkInput() {
  alert('チェック機能は未実装です')
}

watch(() => props.initialItems, (newItems) => {
  rows.value = newItems.length > 0
    ? JSON.parse(JSON.stringify(newItems))
    : [createEmptyRow()]
}, { immediate: true })
</script>
