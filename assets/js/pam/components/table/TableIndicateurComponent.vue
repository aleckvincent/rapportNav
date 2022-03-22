<template>
  <div class="table-custom">
    <table class="table-indicateur">
      <thead class="thead-indicateur">
      <th class="th-indicateur" scope="col">Missions</th>
      <th class="th-indicateur" scope="col">Principale</th>
      <th class="th-indicateur" scope="col">Secondaire</th>
      <th class="total-column th-indicateur" scope="col">Total</th>
      <th class="th-indicateur" scope="col">Observations</th>
      </thead>

      <tbody>
      <tr class="tr-indicateur" v-for="(mission, index) in types">
        <th class="td-nb-hour-sea td-indicateur th-tr-indicateur" scope="row" >
          {{ mission.category.nom }}
        </th>
        <TdEditable @mouseover="i = true" class-list="td-indicateur td-fillable" :value="mission.principale" @change="setValue(mission, $event, 'principale', index)" />
        <div class="tooltip-automatic-calculate">
          <div class="fr-toggle fr-toggle--label-left">
            <input type="checkbox" class="fr-toggle__input" aria-describedby="toggle-726-hint-text" id="toggle-726">
            <label class="fr-toggle__label" for="toggle-726">Calculé automatiquement à partir des déclarations opérationnelles</label>
            <p class="fr-hint-text" id="toggle-726-hint-text">Calculé automatiquement à partir des déclarations opérationnelles</p>
          </div>
        </div>
        <TdEditable class-list="td-indicateur td-fillable" :value="mission.secondaire" @change="setValue(mission, $event, 'secondaire', index)" />
        <TdEditable class-list="td-indicateur td-total" :value="mission.total" total />
        <TdEditable v-model="mission.observations" observation></TdEditable>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import TdEditable from "./TdEditable";
export default {
  name: "TableIndicateurComponent",
  components: {TdEditable},
  props: {
    id : {
      type: Number,
      default: null
    },
    category: {
      type: Number,
      default: null
    },
    types: {
      type: Array,
      default: null
    }
  },
  methods: {
    hiddenToggle(className, scope) {
      let tooltip = $('.' + className + '[data-scope="' + scope + '"]');
      tooltip.toggleClass('d-none');
    },
    displayMessage(e, scope) {
      let messageBox = $('.hint-text-automatic-calculate[data-scope="' + scope + '"]');
      messageBox.toggleClass('d-none')
    },
    setValue(mission, value, scope, index) {
      if(scope === 'principale') {
        mission.principale = value;
      } else {
        mission.secondaire = value;
      }
      this.types[index].total = mission.principale + mission.secondaire;

    }
  },
  data() {
    return {
      i: false
    }
  }
}
</script>

<style scoped>

</style>
