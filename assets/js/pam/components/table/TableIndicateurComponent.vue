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
        <TdEditable class-list="td-indicateur td-fillable" :value="indicateur.principale" @change="setValue(indicateur, $event, 'principale', index)" indicateur />
    <!--    <div class="tooltip-automatic-calculate">
          <div class="fr-toggle fr-toggle--label-left">
            <input type="checkbox" class="fr-toggle__input" aria-describedby="toggle-726-hint-text" id="toggle-726">
            <label class="fr-toggle__label" for="toggle-726">Calculé automatiquement à partir des déclarations opérationnelles</label>
            <p class="fr-hint-text" id="toggle-726-hint-text">Calculé automatiquement à partir des déclarations opérationnelles</p>
          </div>
        </div>-->
        <TdEditable class-list="td-indicateur td-fillable" :value="indicateur.secondaire" @change="setValue(indicateur, $event, 'secondaire', index)" indicateur />
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
    mission: Object,
    controles: Array
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
      if(scope === 'principale') {
        indicateur.principale = value;
      } else {
        indicateur.secondaire = value;
      }

      return this.setTotal(indicateur, index);
    },
    setTotal(indicateur, index) {
      let total = indicateur.principale + indicateur.secondaire;
      this.indicateurs[index].total = !isNaN(total) ? total : null;
    },
    setAutomaticValue(indicateur, value, index) {
      if(this.mission.is_main) {
        indicateur.principale = value;
        indicateur.secondaire = null;
      } else {
        indicateur.secondaire = value;
        indicateur.principale = null;
      }
      return this.setTotal(indicateur, index);

    },
    setAutomaticAssistanceNavire(indicateurCategoryNom, value) {
      if(this.mission.category.nom === 'Assistance aux navires en difficulté et sécurité maritime') {
        this.indicateurs.filter((indicateur, index) => {
          if(indicateur.category.nom === indicateurCategoryNom) {
            this.setAutomaticValue(indicateur, value, index);
          }
        })
      }
    },
    setAutomaticLuttePollution(indicateurCategoryNom, value, isControleOp = false, controles = []) {
      if(this.mission.category.nom === 'Répression contre les rejets illicites, lutte contre les pollutions et protection de l\'environnement') {
        this.indicateurs.filter((indicateur, index) => {
          if(indicateur.category.nom === indicateurCategoryNom) {
            if(isControleOp) {
              let envPollution = [];
              controles.forEach((controle) => {
                envPollution.push(controle.nb_pv_env_pollution);
              });
              let total = 0;
              envPollution.forEach(pv =>  total += pv);
              this.setAutomaticValue(indicateur, total, index);
            } else {
              this.setAutomaticValue(indicateur, value, index);
            }
          }
        })
      }
    },
    setAutomaticPecheIllegale(controles) {
      let nbPvPecheSanitaire = [];
      let nbControlePecheSanitaire = [];

      controles.forEach((controle) => {
        if(controle.category.nom.includes('en mer')) {
          nbControlePecheSanitaire.push(controle.nb_controles_peche_sanitaire);
          nbPvPecheSanitaire.push(controle.nb_pv_peche_sanitaire);
        }
      });

      if(this.mission.category.nom === 'Lutte contre les activités de pêche illégale, gestion du patrimoine marin et des ressources publiques marines') {
        this.indicateurs.filter((indicateur, index) => {
          if(indicateur.category.nom === 'Nombre de navires contrôlés en mer (législation pêche)') {
            let total = 0;
            nbControlePecheSanitaire.forEach((pv) => {
              total += pv;
            })
            this.setAutomaticValue(indicateur, total, index);
          }

          if(indicateur.category.nom === 'Nombre de procès-verbaux dressés (législation pêche)') {
            let total = 0;
            nbPvPecheSanitaire.forEach((pv) => {
              total += pv;
            })
            this.setAutomaticValue(indicateur, total, index);
          }
        })
      }
    }
  },
  watch: {
    'autreMission.nbAssistanceSauvetage': function(value) {
      this.setAutomaticAssistanceNavire('Nombre d\'opérations suivies (ayant fait l\'objet d\'un DEFREP)', value);
    },
    'autreMission.dureeAssistanceSauvetage': function(value) {
      this.setAutomaticAssistanceNavire('Nombre d\'heures de mer', value);
    },
    'autreMission.dureeLuttePollution': function(value) {
      this.setAutomaticLuttePollution('Nombre d\'heures de mer (surveillance et lutte)', value);
    },
    'autreMission.nbLuttePollution': function(value) {
      this.setAutomaticLuttePollution('Nombre d\'opérations de lutte anti-pollution en mer', value);
    },
    'controles': function(controles) {
      this.setAutomaticLuttePollution('Nombre de procès-verbaux d\'infraction dressés', null,true, controles);
      this.setAutomaticPecheIllegale(controles);
    },
    'mission.is_main': function(value) {
      this.setAutomaticAssistanceNavire('Nombre d\'opérations suivies (ayant fait l\'objet d\'un DEFREP)', this.autreMission.nbAssistanceSauvetage);
      this.setAutomaticAssistanceNavire('Nombre d\'heures de mer', this.autreMission.dureeAssistanceSauvetage);
      this.setAutomaticLuttePollution('Nombre d\'heures de mer (surveillance et lutte)', this.autreMission.dureeLuttePollution);
      this.setAutomaticLuttePollution('Nombre d\'opérations de lutte anti-pollution en mer', this.autreMission.nbLuttePollution);
      this.setAutomaticLuttePollution('Nombre de procès-verbaux d\'infraction dressés', null, true, this.controles);
      this.setAutomaticPecheIllegale(this.controles);
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
