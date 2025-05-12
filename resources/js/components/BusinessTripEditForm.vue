<template>
  <div>
    <div v-for="(row, index) in rows" :key="index" class="border p-4 mb-4 rounded">
      <h3 class="font-semibold mb-2">出張費 {{ index + 1 }}</h3>

      <input type="date" :name="'business_trip_expenses[' + index + '][business_trip_date]'" v-model="row.business_trip_date" class="w-full mb-2" />
      <input type="text" :name="'business_trip_expenses[' + index + '][departure]'" v-model="row.departure" class="w-full mb-2" placeholder="出発地" />
      <input type="text" :name="'business_trip_expenses[' + index + '][destination]'" v-model="row.destination" class="w-full mb-2" placeholder="到着地" />
      <input type="text" :name="'business_trip_expenses[' + index + '][purpose]'" v-model="row.purpose" class="w-full mb-2" placeholder="目的" />
      <input type="number" :name="'business_trip_expenses[' + index + '][amount]'" v-model="row.amount" class="w-full mb-2" placeholder="金額" />
      <input type="text" :name="'business_trip_expenses[' + index + '][note]'" v-model="row.note" class="w-full mb-2" placeholder="備考" />
    </div>

    <button type="button" @click="addRow" class="bg-blue-500 text-white px-4 py-1 rounded mr-2">＋行を追加</button>
    <button type="button" @click="removeRow" class="bg-red-500 text-white px-4 py-1 rounded">−行を削除</button>
  </div>
</template>

<script>
export default {
  props: {
    initialItems: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      rows: []
    }
  },
  mounted() {
    if (this.initialItems.length > 0) {
      this.rows = JSON.parse(JSON.stringify(this.initialItems))
    } else {
      this.rows = [
        { business_trip_date: '', departure: '', destination: '', purpose: '', amount: '', note: '' }
      ]
    }
  },
  methods: {
    addRow() {
      this.rows.push({ business_trip_date: '', departure: '', destination: '', purpose: '', amount: '', note: '' })
    },
    removeRow() {
      if (this.rows.length > 1) {
        this.rows.pop()
      }
    }
  }
}
</script>
