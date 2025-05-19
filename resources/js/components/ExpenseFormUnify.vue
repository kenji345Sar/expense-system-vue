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
        :key="field.key"
        class="mb-2"
      >
        <label class="block mb-1">{{ field.label }}</label>

        <input
          v-if="field.type !== 'textarea'"
          :type="field.type || 'text'"
          class="form-input w-full"
          :name="`${namespace}[${index}][${field.key}]`"
          v-model="rows[index][field.key]"
          :placeholder="field.placeholder"
          :readonly="field.readonly || false"
        />

        <textarea
          v-else
          class="form-input w-full"
          :name="`${namespace}[${index}][${field.key}]`"
          v-model="rows[index][field.key]"
          :placeholder="field.placeholder"
          :readonly="field.readonly || false"
        ></textarea>
      </div>
    </div>

    <div v-if="errors.length" class="text-red-600 mb-4">
      <ul>
        <li v-for="(err, i) in errors" :key="i">・{{ err }}</li>
      </ul>
    </div>
    <div v-if="successMessage" class="text-green-600 mb-4">
      {{ successMessage }}
    </div>

    <div class="mt-4 flex gap-2">
      <button type="button" class="bg-green-500 text-white px-4 py-1 rounded mr-2" @click="validateBeforeSubmit">入力チェック</button>
      <button type="button" class="bg-blue-500 text-white px-4 py-1 rounded mr-2" @click="addRow">＋行を追加</button>
      <button type="button" class="bg-red-500 text-white px-4 py-1 rounded mr-2" @click="removeRow">−行を削除</button>
    </div>

    <input
      type="hidden"
      name="details_json"
      :value="JSON.stringify(rows)"
    />
  </div>
</template>

<script setup>
import { ref, watch, watchEffect } from 'vue'

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
const errors = ref([])
const successMessage = ref('');


function createEmptyRow() {
  const row = {}
  props.fields.forEach(field => {
    if (field.type === 'number') {
      row[field.name] = 0
    } else {
      row[field.name] = ''
    }
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

function validateBeforeSubmit() {
  errors.value = [];

  rows.value.forEach((row, i) => {
    props.fields.forEach(field => {
      if (field.required === false) return;

      const key = field.key;
      const label = field.label;
      const value = row[key];

      // 単純な空チェック
      if (!value && value !== 0) {
        errors.value.push(`No.${i + 1} ${label}が未入力です`);
      }

      // 数値タイプの追加チェック
      if (field.type === 'number' && isNaN(value)) {
        errors.value.push(`No.${i + 1} ${label}は数値で入力してください`);
      }
    });
  });

  if (errors.value.length === 0) {
    successMessage.value = '入力内容に問題はありません。';
    // document.querySelector('form').submit();
  }
}

watch(() => props.initialItems, (newItems) => {
  rows.value = newItems.length > 0
    ? JSON.parse(JSON.stringify(newItems))
    : [createEmptyRow()]
}, { immediate: true })


watchEffect(() => {
  rows.value.forEach(row => {
    const quantity = parseFloat(row.quantity)
    const unitPrice = parseFloat(row.unit_price)

    if (!isNaN(quantity) && !isNaN(unitPrice)) {
      const total = quantity * unitPrice
      if ('total_price' in row) {
        row.total_price = total
      }
    } else {
      if ('total_price' in row) {
        row.total_price = null
      }
    }
  })
})


</script>
