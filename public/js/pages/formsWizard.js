/*
 *  Document   : formsWizard.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Forms Wizard page
 */

var FormsWizard = function() {

    return {
        init: function() {
            /*
             *  Jquery Wizard, Check out more examples and documentation at http://www.thecodemine.org
             *  Jquery Validation, Check out more examples and documentation at https://githusu.com/jzaefferer/jquery-validation
             */

            /* Initialize Progress Wizard */
            $('#progress-wizard').formwizard({focusFirstInput: true, disableUIStyles: true, inDuration: 0, outDuration: 0, validationEnabled: true,
                validationOptions: {
                    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                    errorElement: 'span',
                    errorPlacement: function(error, e) {
                        e.parents('.form-group > div').append(error);
                    },
                    highlight: function(e) {
                        $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                        $(e).closest('.help-block').remove();
                    },
                    success: function(e) {
                        // You can use the following if you would like to highlight with green color the input after successful validation!
                        e.closest('.form-group').removeClass('has-success has-error'); // e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                        e.closest('.help-block').remove();
                    },
                    rules: {
                        denomination: {
                            required: true,
                            minlength: 2
                        },

                        region: {
                            required: true,
                        },

                        prenom_promoteur:{
                            required: true,
                        },
                        datenais_promoteur:{
                            required: true,
                        },
                        genre:{
                            required: true,
                        },
                        telephone_promoteur:{
                            required: true,
                        },
                        numero_identite:{
                            required: true,
                        },
                        email_promoteur:{
                            required: true,
                            email: true
                        },
                        email_entreprise:{
                            required: true,
                            email: true
                        },
                        type_identite_promoteur:{
                            required: true,
                        },
                        date_identification:{
                            required: true,
                        },
                        autorite_delivrance_identification:{
                            required: true,
                        },
                        lieu_etablissement_identification:{
                            required: true,
                        },
                        region_residence:{
                            required: true,
                        },
                        province_residence:{
                            required: true,
                        },
                        occupation_pro_actuelle:{
                            required: true,
                        },
                        commune_residence:{
                            required: true,
                        },
                        province_residence:{
                            required: true,
                        },
                        arrondissement_residence:{
                            required: true,
                        },
                        situation_residence:{
                            required: true,
                        },
                        niveau_instruction:{
                            required: true,
                        },
                        domaine_etude:{
                            required: true,
                        },
                        occupation_pro_actuelle:{
                            required: true,
                        },
                        docidentite:{
                            required: true,
                        },
                        membre_ass:{
                            required: true,
                        },
                        province: {
                            required: true,

                        },
                        commune: {
                            required: true,
                        },
                    telephone_entreprise: {
                            required: true,
                        },
                        secteur_activite: {
                            required: true,
                        },
                        agrement_exige: {
                            required: true,
                        },
                        formalise: {
                            required: true,
                        },
                        maillon_activite: {
                            required: true,
                        },
                        provenance_clientele:{
                            required: true,
                        },
                        nature_client:{
                            required: true,
                        },
                        description_activite:{
                            required: true,
                        },

                        val_password: {
                            required: true,
                            minlength: 5
                        },
                        val_confirm_password: {
                            required: true,
                            equalTo: '#val_password'
                        },
                        nombre_annee_experience:{
                            number:true,
                            required: true,
                        },
                        val_email: {
                            required: true,
                            email: true
                        },
                        val_terms: {
                            required: true
                        }
                    },
                    messages: {
                        denomination: {
                            required: 'Le champ denomination est obligatoire',
                            minlength: 'Ce champ doit contenir au moins deux caractères'
                        },
                        nombre_annee_experience: {
                            required: 'Ce champ est obligatoire',
                            number: 'Entrez SVP un nombre',
                            max: 'SVP entrez un nombre inférieur à 100'
                        },
                        telephone_promoteur:'Le champ nom est obligatoire',
                        genre:'Le champ nom est obligatoire',
                        agrement_exige:'Ce champ est obligatoire',
                        numero_identite:'Le champ nom est obligatoire',
                        docidentite:'Le champ document est obligatoire',
                        formalise:'Ce champ est obligatoire',
                        lieu_etablissement_identification:'Le champ lieu est obligatoire',
                        autorite_delivrance_identification:'Le champ autorité de delivrance est obligatoire',
                        date_identification:'Le champ date  est obligatoire',
                        type_identite_promoteur:'Le champ type identite est obligatoire',
                        region_residence:'Le champ region est obligatoire',
                        province_residence:'Le champ province est obligatoire',
                        commune_residence:'Le champ commune est obligatoire',
                        arrondissement_residence:'Le champ village/secteur est obligatoire',
                        situation_residence:"Le champ situation residence est obligatoire",
                        niveau_instructions:"Le champ niveau d'instruction est obligatoire",
                        niveau_instruction:'Le champ nom est obligatoire',
                        domaine_etude:'Le champ nom est obligatoire',
                        occupation_pro_actuelle:'Le champ occupation professionnelle actuelle est obligatoire',
                        formation_activite:'Ce champ est obligatoire',
                        membre_ass:'Ce champ est obligatoire',
                        prenom_promoteur: {
                            required: 'Le champ prénom est obligatoire',
                        },
                        datenais_promoteur: {
                            required: 'Le champ date de naissance est obligatoire',
                        },
                        region: {
                            required: 'Le champ province est obligatoire',
                            minlength: 'Ce champ doit contenir au moins deux caractères'
                        },
                        province: {
                            required: 'Le champ province est obligatoire',
                            minlength: 'Ce champ doit contenir au moins deux caractères'
                        },
                        commune: {
                            required: 'Le champ commune est obligatoire',
                            minlength: 'Ce champ doit contenir au moins deux caractères'
                        },
                        arrondissement: {
                            required: 'Le champ arrondissement est obligatoire',
                            minlength: 'Ce champ doit contenir au moins deux caractères'
                        },
                        telephone_entreprise: {
                            required: 'Le champ telephone est obligatoire',
                            minlength: 'Ce champ doit contenir au moins deux caractères'
                        },
                        secteur_activite: {
                            required: 'Ce champ est obligatoire',
                        },
                        maillon_activite: {
                            required: 'Ce champ est obligatoire',
                        },
                        nombre_annee_existence:{
                            required: 'Ce champ est obligatoire',
                        },
                        provenance_clientele:{
                            required: 'Ce champ est obligatoire',
                        },
                        nature_client:{
                            required: 'Ce champ est obligatoire',
                        },
                        description_activite:'Ce champ est obligatoire',
                        val_password: {
                            required: 'Please provide a password',
                            minlength: 'Your password must be at least 5 characters long'
                        },
                        val_confirm_password: {
                            required: 'Please provide a password',
                            minlength: 'Your password must be at least 5 characters long',
                            equalTo: 'Please enter the same password as above'
                        },
                        email_entreprise:{
                            required: 'Ce champ est obligatoire',
                            email:"Entrez une adresse email correcte"
                        },
                        email_promoteur:{
                            required: 'Le champ email est obligatoire',
                            email:"Entrez une adresse email correcte"
                        },
                        val_terms: 'Please accept the terms to continue'
                    }
                }

            });

            // Get the progress bar and change its width when a step is shown
            var progressBar = $('#progress-bar-wizard');
            progressBar
                .css('width', '33%')
                .attr('aria-valuenow', '33');

            $("#progress-wizard").bind('step_shown', function(event, data){
		if (data.currentStep === 'progress-first') {
                    progressBar
                        .css('width', '33%')
                        .attr('aria-valuenow', '33')
                        .removeClass('progress-bar-warning progress-bar-success')
                        .addClass('progress-bar-danger');
                }
                else if (data.currentStep === 'progress-second') {
                    progressBar
                        .css('width', '66%')
                        .attr('aria-valuenow', '66')
                        .removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-warning');
                }
                else if (data.currentStep === 'progress-third') {
                    progressBar
                        .css('width', '100%')
                        .attr('aria-valuenow', '100')
                        .removeClass('progress-bar-danger progress-bar-warning')
                        .addClass('progress-bar-success');
                }
            });

            /* Initialize Basic Wizard */
            $('#basic-wizard').formwizard({disableUIStyles: true, inDuration: 0, outDuration: 0});

            /* Initialize Advanced Wizard with Validation */
            $('.advanced-wizard').formwizard({
                disableUIStyles: true,
                validationEnabled: true,
                validationOptions: {
                    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                    errorElement: 'span',
                    errorPlacement: function(error, e) {
                        e.parents('.form-group > div').append(error);
                    },
                    highlight: function(e) {
                        $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                        $(e).closest('.help-block').remove();
                    },
                    success: function(e) {
                        // You can use the following if you would like to highlight with green color the input after successful validation!
                        e.closest('.form-group').removeClass('has-success has-error'); // e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                        e.closest('.help-block').remove();
                    },
                    rules: {
                        denomination: {
                            required: true,
                            minlength: 2
                        },

                        region: {
                            required: true,

                        },
                        province: {
                            required: true,

                        },
                        commune: {
                            required: true,
                        },
                    telephone_entreprise: {
                            required: true,
                        },
                        secteur_activite: {
                            required: true,
                        },
                        maillon_activite: {
                            required: true,
                        },
                        provenance_clientele:{
                            required: true,
                        },
                        nature_client:{
                            required: true,
                        },
                        description_activite:{
                            required: true,
                        },
                        nombre_annee_existence:{
                            required: true,
                        },
                        val_password: {
                            required: true,
                            minlength: 5
                        },
                        val_confirm_password: {
                            required: true,
                            equalTo: '#val_password'
                        },
                        val_email: {
                            required: true,
                            email: true
                        },
                        val_terms: {
                            required: true
                        }
                    },
                    messages: {
                        denomination: {
                            required: 'Le champ denomination est obligatoire',
                            minlength: 'Ce champ doit contenir au moins deux caractères'
                        },
                        region: {
                            required: 'Le champ province est obligatoire',
                            minlength: 'Ce champ doit contenir au moins deux caractères'
                        },
                        province: {
                            required: 'Le champ province est obligatoire',
                            minlength: 'Ce champ doit contenir au moins deux caractères'
                        },
                        commune: {
                            required: 'Le champ commune est obligatoire',
                            minlength: 'Ce champ doit contenir au moins deux caractères'
                        },
                        arrondissement: {
                            required: 'Le champ arrondissement est obligatoire',
                            minlength: 'Ce champ doit contenir au moins deux caractères'
                        },
                        telephone_entreprise: {
                            required: 'Le champ telephone est obligatoire',
                            minlength: 'Ce champ doit contenir au moins deux caractères'
                        },
                        secteur_activite: {
                            required: 'ce champ est obligatoire',
                        },
                        maillon_activite: {
                            required: 'ce champ est obligatoire',
                        },
                        nombre_annee_existence:{
                            required: 'ce champ est obligatoire',
                        },
                        provenance_clientele:{
                            required: 'ce champ est obligatoire',
                        },
                        nature_client:{
                            required: 'ce champ est obligatoire',
                        },
                        description_activite:{
                            required: 'ce champ est obligatoire',
                        },
                        val_password: {
                            required: 'Please provide a password',
                            minlength: 'Your password must be at least 5 characters long'
                        },
                        val_confirm_password: {
                            required: 'Please provide a password',
                            minlength: 'Your password must be at least 5 characters long',
                            equalTo: 'Please enter the same password as above'
                        },
                        val_email: 'Entrer une adresse email correcte',
                        required:"Ce champ est obligatoire",
                        val_terms: 'Please accept the terms to continue'
                    }
                },
                inDuration: 0,
                outDuration: 0
            });

            /* Initialize Clickable Wizard */
            var clickableWizard = $('#clickable-wizard');

            clickableWizard.formwizard({disableUIStyles: true, inDuration: 0, outDuration: 0});

            $('.clickable-steps a').on('click', function(){
                var gotostep = $(this).data('gotostep');

                clickableWizard.formwizard('show', gotostep);
            });
           // $('#masked_date').mask('99/99/9999');
            $('#masked_date2').mask('99-99-9999');
            $('#masked_phone').mask('(999) 999-9999');
            $('.principal').mask('99-99-99-99');
            $('#secondaire_phone').mask('99-99-99-99');
            $('#masked_phone_ext').mask('(999) 999-9999? x99999');
            $('#masked_taxid').mask('99-9999999');
            $('#masked_ssn').mask('999-99-9999');
            $('#masked_pkey').mask('a*-999-a999');
        }
    };
}();
