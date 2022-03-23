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
      <tr class="tr-indicateur" v-for="(indicateur, index) in indicateurs">
        <th class="td-nb-hour-sea td-indicateur th-tr-indicateur" scope="row" >
          {{ indicateur.category.nom }}
        </th>
        <TdEditable class-list="td-indicateur td-fillable" :value="indicateur.principale" @change="setValue(indicateur, $event, 'principale', index)" />
    <!--    <div class="tooltip-automatic-calculate">
          <div class="fr-toggle fr-toggle--label-left">
            <input type="checkbox" class="fr-toggle__input" aria-describedby="toggle-726-hint-text" id="toggle-726">
            <label class="fr-toggle__label" for="toggle-726">Calculé automatiquement à partir des déclarations opérationnelles</label>
            <p class="fr-hint-text" id="toggle-726-hint-text">Calculé automatiquement à partir des déclarations opérationnelles</p>
          </div>
        </div>-->
        <TdEditable class-list="td-indicateur td-fillable" :value="indicateur.secondaire" @change="setValue(indicateur, $event, 'secondaire', index)" />
        <TdEditable class-list="td-indicateur td-total" :value="indicateur.total" total />
        <TdEditable v-model="indicateur.observations" observation></TdEditable>
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
    autreMission: Object,
    mission: Object
  },
  mounted() {
    this.setAutomaticValue();
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
    setValue(indicateur, value, scope, index) {
      console.log(value);
      if(scope === 'principale') {
        indicateur.principale = value;
      } else {
        indicateur.secondaire = value;
      }

      this.indicateurs[index].total = indicateur.principale + indicateur.secondaire;
    },
    setAutomaticValue() {

    },
  },
  watch: {
    'autreMission.nbAssistanceSauvetage': function(newVal, old) {
      if(this.mission.category.nom === 'Assistance aux navires en difficulté et sécurité maritime') {
        this.indicateurs.filter((indicateur, index) => {
          if(indicateur.category.nom === 'Nombre d\'opérations suivies (ayant fait l\'objet d\'un DEFREP)') {
            if(this.mission.checked) {
              indicateur.principale = newVal;
            } else {
              indicateur.secondaire = newVal;
            }

          }
        })
      }
    }
  },
  data() {
    return {
      indicateurs: this.mission.indicateurs
    }
  }
}
</script>

<style scoped>

</style>
