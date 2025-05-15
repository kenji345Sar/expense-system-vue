<template>
  <component
    :is="resolvedComponent"
    :initial-items="initialItems"
  />
</template>

<script>
import BusinessTripForm from './BusinessTripForm.vue'
import TransportationForm from './TransportationForm.vue'
import SuppliesForm from './SuppliesForm.vue'
import EntertainmentForm from './EntertainmentForm.vue'

export default {
  props: {
    type: {
      type: String,
      required: true  // 例: "business_trip", "transportation"
    },
    initialItems: {
      type: Array,
      default: () => []
    }
  },
  computed: {
    resolvedComponent() {
      return {
        business_trip: BusinessTripForm,
        transportation: TransportationForm,
        supplies: SuppliesForm,
        entertainment: EntertainmentForm
      }[this.type]
    }
  }
}
</script>
