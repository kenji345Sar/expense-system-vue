<script setup>
import { ref, onMounted } from 'vue'
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
  { name: 'use_date', type: 'date', label: '利用日' },
  { name: 'departure', type: 'text', label: '出発地' },
  { name: 'arrival', type: 'text', label: '到着地' },
  { name: 'route', type: 'text', label: '経路' },
  { name: 'amount', type: 'number', label: '金額' },
  { name: 'remarks', type: 'text', label: '備考' }
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
    if (!row.use_date) errors.value.push(`No.${i + 1} 利用日が未入力です`)
    if (!row.departure) errors.value.push(`No.${i + 1} 出発地が未入力です`)
    if (!row.arrival) errors.value.push(`No.${i + 1} 到着地が未入力です`)
    if (!row.amount || isNaN(row.amount)) errors.value.push(`No.${i + 1} 金額が不正です`)
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
</script>

<template>
  <div>
    <FormRow
      v-for="(row, index) in rows"
      :key="index"
      :index="index"
      :row="row"
      :fields="fields"
      namespace="transportation_expenses"
      label="交通費"
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
