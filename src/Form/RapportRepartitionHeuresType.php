<?php

namespace App\Form;

use App\Entity\RapportRepartitionHeures;
use App\Form\DataTransformer\TimeToIntegerTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportRepartitionHeuresType extends AbstractType {
    /** @var TimeToIntegerTransformer */
    private $transformer;

    public function __construct(TimeToIntegerTransformer $transformer) {
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
          ->add('controleMer', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleTerre', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleAerien', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleAireProtegeeMer', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleAireProtegeeTerre', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleAireProtegeeAerien', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controlePollutionMer', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controlePollutionTerre', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controlePollutionAerien', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleEnvironnementMer', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleEnvironnementTerre', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleEnvironnementAerien', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleChlordeconePartielMer', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleChlordeconePartielTerre', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleChlordeconeTotalMer', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleChlordeconeTotalTerre', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('controleCroise', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('immigration', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('visiteSecurite', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('nombreVisiteSecurite', IntegerType::class, [
              'required' => false,
          ])
          ->add('surveillanceManifestationMer', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('surveillanceManifestationTerre', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('surveillanceDpmMer', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('surveillanceDpmTerre', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('surete', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('maintienOrdre', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('assistance', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('plongee', TimeType::class, [
              'widget' => "single_text",
              'required' => false,
          ])
          ->add('sauvegardeHumaineNbHeureMer', TimeType::class, [
            'widget' => "single_text",
            'required' => false,
          ])
          ->add('sauvegardeHumaineNbHeuresVol', TimeType::class, [
            'widget' => "single_text",
            'required' => false,
          ])
          ->add('sauvegardeHumaineNbOpeConduites', IntegerType::class, [
            'required' => false,
          ])
          ->add('sauvegardeHumaineNbPersonnesSecourues', IntegerType::class, [
            'required' => false,
          ])
          ->add('sauvegardeHumaineMigratoireNbHeuresMer', TimeType::class, [
            'widget' => "single_text",
            'required' => false,
          ])
          ->add('sauvegardeHumaineMigratoireNbHeuresVol', TimeType::class, [
            'widget' => "single_text",
            'required' => false,
          ])
          ->add('sauvegardeHumaineMigratoireNbOpeConduite', IntegerType::class, [
            'required' => false,
          ])
          ->add('sauvegardeHumaineMigratoireNbEmbarcationsAssisteesRetourTerre', IntegerType::class, [
            'required' => false,
          ])
          ->add('sauvegardeHumaineMigratoireNbEmbarcationsSansIntervention', IntegerType::class, [
            'required' => false,
          ])
          ->add('sauvegardeHumaineMigratoireNbOpeSauvetageConduites', IntegerType::class, [
            'required' => false,
          ])
          ->add('sauvegardeHumaineMigratoireNbPersonnesSecourues', IntegerType::class, [
            'required' => false,
          ])
          ->add('assistanceNbHeuresMer', TimeType::class, [
            'widget' => "single_text",
            'required' => false,
          ])
          ->add('assistanceNbHeuresVol', TimeType::class, [
            'widget' => "single_text",
            'required' => false,
          ])
          ->add('assistanceNbOpeANED', IntegerType::class, [
            'required' => false,
          ])
          ->add('assistanceNbInterventionMiseEnDemeure', IntegerType::class, [
            'required' => false,
          ])
          ->add('assistanceNbMiseEnDemeureEvaluation', IntegerType::class, [
            'required' => false,
          ])
          ->add('assistanceNbMiseEnOeuvreCAPINAV', IntegerType::class, [
            'required' => false,
          ])
          ->add('assistanceNbRemorquages', IntegerType::class, [
            'required' => false,
          ])
          ->add('assistanceNbOpeMaintenanceSignalisation', IntegerType::class, [
            'required' => false,
          ])
          ->add('assistanceNbOpeDeminage', IntegerType::class, [
            'required' => false,
          ])
          ->add('assistanceNbMunitionsDetruites', IntegerType::class, [
            'required' => false,
          ])
          ->add('assistanceNbMunitionsDetruites', IntegerType::class, [
            'required' => false,
          ])
          ->add('assistancePoidsMatiereActive', IntegerType::class, [
            'required' => false,
          ])
          ->add('lutteTraficArmesNbHeuresMer', TimeType::class, [
            'widget' => "single_text",
            'required' => false,
          ])
          ->add('lutteTraficArmesNbHeureVol', TimeType::class, [
            'widget' => "single_text",
            'required' => false,
          ])
          ->add('lutteTraficArmesNbOpeMer', IntegerType::class, [
            'required' => false,
          ])
          ->add('lutteTraficArmesNbInspectionsMer', IntegerType::class, [
            'required' => false,
          ])
          ->add('lutteTraficArmesNbNaviresSaisisMer', IntegerType::class, [
            'required' => false,
          ])
          ->add('lutteTraficArmesNbArmesMunitionsSaisies', IntegerType::class, [
            'required' => false,
          ])
          ->add('lutteTraficStupefiantNbHeuresMer', TimeType::class, [
            'widget' => "single_text",
            'required' => false,
          ])
          ->add('lutteTraficStupefiantNbHeuresVol', TimeType::class, [
            'widget' => "single_text",
            'required' => false,
          ])
          ->add('lutteTraficStupefiantNbOpeNARCO', IntegerType::class, [
            'required' => false,
          ])
          ->add('lutteTraficStupefiantNbInspectionsMer', IntegerType::class, [
            'required' => false,
          ])
          ->add('lutteTraficStupefiantNbNavireSaisisMer', IntegerType::class, [
            'required' => false,
          ])
          ->add('lutteTraficStupefiantKgSaisis', IntegerType::class, [
            'required' => false,
          ])

          ->add('lutteTraficEspecesNbHeuresMer', TimeType::class, [
            'widget' => "single_text",
            'required' => false,
          ])
          ->add('lutteTraficEspecesNbHeuresVol', TimeType::class, [
            'widget' => "single_text",
            'required' => false,
          ])
          ->add('lutteTraficEspecesNbNaviresSaisisMer', IntegerType::class, [
            'required' => false,
          ])
          ->add('lutteTraficEspecesNbSaisis', IntegerType::class, [
            'required' => false,
          ])

          ->add('immigrationNbHeuresVol', TimeType::class, [
            'required' => false,
            'widget' => 'single_text'
          ])

          ->add('immigrationNbNaviresInterceptes', IntegerType::class, [
            'required' => false,
          ])

          ->add('immigrationNbMigrantInterceptes', IntegerType::class, [
            'required' => false,
          ])

          ->add('immigrationNbPasseursInterceptes', IntegerType::class, [
            'required' => false,
          ])
          ->add('luttePollutionDeploiementEnMer', IntegerType::class, [
            'required' => false
          ])
          ->add('luttePollutionNbDeroutements', IntegerType::class, [
            'required' => false
          ])
          ->add('luttePollutionNbInfractions', IntegerType::class, [
            'required' => false
          ])
          ->add('luttePollutionPV', IntegerType::class, [
            'required' => false
          ])
          ->add('luttePollutionParticipationANTIPOL', IntegerType::class, [
            'required' => false
          ])
          ->add('luttePollutionNbPollutionsDetectees', IntegerType::class, [
            'required' => false
          ])
          ->add('luttePecheNbNavireControleVHFmer', IntegerType::class, [
            'required' => false
          ])
          ->add('luttePecheKgProduitsSaisisMer', IntegerType::class, [
            'required' => false
          ])
          ->add('protectionCulturelNbHeuresMer', TimeType::class, [
            'required' => false,
            'widget' => 'single_text'
          ])
          ->add('protectionCulturelNbOpePoliceBCM', IntegerType::class, [
            'required' => false
          ])
          ->add('protectionCulturelNbOpeScientifiques', IntegerType::class, [
            'required' => false
          ])
          ->add('sureteMaritimeNbHeuresVol', TimeType::class, [
            'required' => false,
            'widget' => 'single_text'
          ])
          ->add('sureteMaritimeNbOpeMer', IntegerType::class, [
            'required' => false
          ])
          ->add('sureteMaritimeNbTraverseesProtegees', IntegerType::class, [
            'required' => false
          ])
          ->add('souveraineteNbNavireApprocheMaritime', IntegerType::class, [
            'required' => false
          ])
          ->add('souveraineteNbHeuresMerPiraterie', TimeType::class, [
            'required' => false,
            'widget' => 'single_text'
          ])
          ->add('souveraineteNbHeuresVolPiraterie', TimeType::class, [
            'required' => false,
            'widget' => 'single_text'
          ])


        ;
      $builder->get('controleMer')
          ->addModelTransformer($this->transformer);
      $builder->get('controleTerre')
          ->addModelTransformer($this->transformer);
      $builder->get('controleAerien')
          ->addModelTransformer($this->transformer);
      $builder->get('controleAireProtegeeMer')
          ->addModelTransformer($this->transformer);
      $builder->get('controleAireProtegeeTerre')
          ->addModelTransformer($this->transformer);
      $builder->get('controleAireProtegeeAerien')
          ->addModelTransformer($this->transformer);
      $builder->get('controlePollutionMer')
          ->addModelTransformer($this->transformer);
      $builder->get('controlePollutionTerre')
          ->addModelTransformer($this->transformer);
      $builder->get('controlePollutionAerien')
          ->addModelTransformer($this->transformer);
      $builder->get('controleEnvironnementMer')
          ->addModelTransformer($this->transformer);
      $builder->get('controleEnvironnementTerre')
          ->addModelTransformer($this->transformer);
      $builder->get('controleEnvironnementAerien')
          ->addModelTransformer($this->transformer);
      $builder->get('controleChlordeconeTotalMer')
          ->addModelTransformer($this->transformer);
      $builder->get('controleChlordeconeTotalTerre')
          ->addModelTransformer($this->transformer);
      $builder->get('controleChlordeconePartielMer')
          ->addModelTransformer($this->transformer);
      $builder->get('controleChlordeconePartielTerre')
          ->addModelTransformer($this->transformer);
      $builder->get('controleCroise')
          ->addModelTransformer($this->transformer);
      $builder->get('immigration')
          ->addModelTransformer($this->transformer);
      $builder->get('visiteSecurite')
          ->addModelTransformer($this->transformer);
      $builder->get('surveillanceManifestationMer')
          ->addModelTransformer($this->transformer);
      $builder->get('surveillanceManifestationTerre')
          ->addModelTransformer($this->transformer);
      $builder->get('surveillanceDpmMer')
          ->addModelTransformer($this->transformer);
      $builder->get('surveillanceDpmTerre')
          ->addModelTransformer($this->transformer);
      $builder->get('surete')
          ->addModelTransformer($this->transformer);
      $builder->get('maintienOrdre')
          ->addModelTransformer($this->transformer);
      $builder->get('assistance')
          ->addModelTransformer($this->transformer);
      $builder->get('plongee')
          ->addModelTransformer($this->transformer);
      $builder->get('sauvegardeHumaineNbHeureMer')
        ->addModelTransformer($this->transformer);
      $builder->get('sauvegardeHumaineNbHeuresVol')
        ->addModelTransformer($this->transformer);
      $builder->get('sauvegardeHumaineMigratoireNbHeuresMer')
        ->addModelTransformer($this->transformer);
      $builder->get('sauvegardeHumaineMigratoireNbHeuresVol')
        ->addModelTransformer($this->transformer);

      $builder->get('assistanceNbHeuresMer')
        ->addModelTransformer($this->transformer);
      $builder->get('assistanceNbHeuresVol')
        ->addModelTransformer($this->transformer);


      $builder->get('lutteTraficArmesNbHeuresMer')
        ->addModelTransformer($this->transformer);
      $builder->get('lutteTraficArmesNbHeureVol')
        ->addModelTransformer($this->transformer);

      $builder->get('lutteTraficStupefiantNbHeuresMer')
        ->addModelTransformer($this->transformer);
      $builder->get('lutteTraficStupefiantNbHeuresVol')
        ->addModelTransformer($this->transformer);

      $builder->get('lutteTraficEspecesNbHeuresMer')
        ->addModelTransformer($this->transformer);
      $builder->get('lutteTraficEspecesNbHeuresVol')
        ->addModelTransformer($this->transformer);

      $builder->get('immigrationNbHeuresVol')
        ->addModelTransformer($this->transformer);

      $builder->get('protectionCulturelNbHeuresMer')
        ->addModelTransformer($this->transformer);

      $builder->get('sureteMaritimeNbHeuresVol')
        ->addModelTransformer($this->transformer);

      $builder->get('souveraineteNbHeuresMerPiraterie')
        ->addModelTransformer($this->transformer);

      $builder->get('souveraineteNbHeuresVolPiraterie')
        ->addModelTransformer($this->transformer);


    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => RapportRepartitionHeures::class,
        ]);
    }
}
