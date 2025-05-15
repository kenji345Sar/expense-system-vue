<script setup>
import { ref, onMounted,watchEffect } from 'vue'
import FormRow from './FormRow.vue'

const props = defineProps({
  initialItems: {
    type: Array,
    default: () => []
  }
})

const errors = ref([])
const rows = ref([])

const fields = [
  { name: 'supply_date', type: 'date', label: '購入日' },
  { name: 'item_name', type: 'text', label: '品名' },
  { name: 'quantity', type: 'text', label: '数量' },
  { name: 'unit_price', type: 'text', label: '単価' },
  { name: 'total_price', type: 'number', label: '合計金額' },
  { name: 'remarks', type: 'text', label: '備考(任意)' }
]

function createEmptyRow() {
  return Object.fromEntries(fields.map(f => [f.name, '']))
}

function addRow() {
  rows.value.push(createEmptyRow())
}

function removeRow() {
  if (rows.value.length > 1) rows.value.pop()
}

function validateBeforeSubmit() {
  errors.value = []
  rows.value.forEach((row, i) => {
    if (!row.supply_date) errors.value.push(`No.${i + 1} 購入日が未入力です`)
    if (!row.item_name) errors.value.push(`No.${i + 1} 品名が未入力です`)
    if (!row.quantity) errors.value.push(`No.${i + 1} 数量が未入力です`)
    if (!row.unit_price) errors.value.push(`No.${i + 1} 単価が未入力です`)
    if (!row.total_price  || isNaN(row.total_price )) errors.value.push(`No.${i + 1} 金額が不正です`)
  })

  if (errors.value.length === 0) {
    document.querySelector('form').submit()
  }
}

onMounted(() => {
  if (Array.isArray(props.initialItems) && props.initialItems.length > 0) {
    rows.value = JSON.parse(JSON.stringify(props.initialItems))
  } else {
    rows.value = [createEmptyRow()]
  }
})

watchEffect(() => {
  rows.value.forEach(row => {
    const quantity = parseFloat(row.quantity)
    const unitPrice = parseFloat(row.unit_price)
    if (!isNaN(quantity) && !isNaN(unitPrice)) {
      row.total_price = quantity * unitPrice
    } else {
      row.total_price = ''
    }
  })
})


</script>

<template>
  <div>
    <FormRow
      v-for="(row, index) in rows"
      :key="index"
      :index="index"
      :row="row"
      :fields="fields"
      namespace="supplies_expenses"
      label="備品消耗品"
    />

    <div v-if="errors.length" class="text-red-600 mb-4">
      <ul>
        <li v-for="(err, i) in errors" :key="i">・{{ err }}</li>
      </ul>
    </div>

    <button type="button" @click="validateBeforeSubmit" class="bg-green-500 text-white px-4 py-1 rounded mr-2">入力チェック</button>
    <button type="button" @click="addRow" class="bg-blue-500 text-white px-4 py-1 rounded mr-2">＋行を追加</button>
    <button type="button" @click="removeRow" class="bg-red-500 text-white px-4 py-1 rounded">−行を削除</button>
  </div>
</template>
