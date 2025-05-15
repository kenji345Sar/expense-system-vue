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
  { name: 'entertainment_date', type: 'date', label: '利用日' },
  { name: 'client_name', type: 'text', label: '接待相手' },
  { name: 'place', type: 'text', label: '場所' },
  { name: 'content', type: 'text', label: '内容' },
  { name: 'amount', type: 'number', label: '金額' },
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

function validateBeforeSubmit(event) {
  event.preventDefault(); // フォームの送信を防ぐ

  errors.value = []
  rows.value.forEach((row, i) => {
    if (!row.entertainment_date) errors.value.push(`No.${i + 1} 利用日が未入力です`)
    if (!row.client_name) errors.value.push(`No.${i + 1} 接待先が未入力です`)
    if (!row.place) errors.value.push(`No.${i + 1} 場所が未入力です`)
    if (!row.content) errors.value.push(`No.${i + 1} 内容が未入力です`)
    if (!row.amount || isNaN(row.amount)) errors.value.push(`No.${i + 1} 金額が不正です`)
  })

  // エラーがない場合は画面そのまま
  if (errors.value.length === 0) {
    console.log('エラーなし：画面はそのままにします');
    return;
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
      namespace="entertainment_expenses"
      label="接待費"
    />

    <div v-if="errors.length" class="text-red-600 mb-4">
      <ul>
        <li v-for="(err, i) in errors" :key="i">・{{ err }}</li>
      </ul>
    </div>

    <button type="button" @click="validateBeforeSubmit($event)" class="bg-green-500 text-white px-4 py-1 rounded mr-2">入力チェック</button>
    <button type="button" @click="addRow" class="bg-blue-500 text-white px-4 py-1 rounded mr-2">＋行を追加</button>
    <button type="button" @click="removeRow" class="bg-red-500 text-white px-4 py-1 rounded">−行を削除</button>
  </div>
</template>
