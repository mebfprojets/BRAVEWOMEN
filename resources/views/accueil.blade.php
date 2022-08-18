@extends("layouts.public")
@section('active_accueil', 'active')
@section("class", "accueil")
@section("section-title")
@endsection
@section("main-content")
<div class="accueil">
    <section id="faq" class="faq section-bg" style="margin-top:0px; padding-top:10px !important">
        <div class="container" data-aos="fade-up">
          <div class="section-title" style="padding-bottom: 20px;">
            <h2>Projet BRAVE WOMEN</h2>
           {{-- <p id="horloge"></p> --}}
            <hr>
          </div>
          <div class="row bravedesc">
              <p style="text-align: justify; margin-bottom:40px;">
                  Le Gouvernement du Burkina Faso a signé en avril 2021 un accord avec la Banque Islamique de Développement (BID) pour l’implémentation d’un programme d’assistance à la résilience des entreprises à valeur ajoutée de femmes au Burkina Faso dénommé « BRAVE Women Burkina », le projet BRAVE Women Burkina s’inscrit dans un programme « Business Resilience Assistance for adding-Value Enterprises for Women (BRAVE Women) » initié par la Société Islamique pour le Développement du Secteur Privé (SID), la branche en charge du secteur privé de la Banque Islamique de Développement (BID). Il vise à offrir une assistance technique et financière aux entreprises détenues/dirigées par des femmes dans des environnements fragiles.
Financé par le Women Enterpreneurs Finance Initiative (We-Fi) qui est un fonds fiduciaire multi-donateurs hébergé par le Groupe de la Banque mondiale, le programme est implémenté au Burkina Faso par la Maison de l’Entreprise du Burkina Faso (MEBF).
              </p>
            </div>
          <div class="faq-list row">
            <ul>
              <li data-aos="fade-up">
                  <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">COMPOSANTE 1 : RENFORCEMENT DES CAPACITÉS DE RÉSILIENCE DES ENTREPRISES <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                    <p>
                      Renforcement des capacités de résilience des entreprises à travers la formation d'entreprises qualifiées (entreprises détenues et ou dirigées par des femmes) sur la gestion des crises et de préparer des plans de continuité des activités
                    </p>
                  </div>
                </li>
                <li data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-2" class="collapsed">COMPOSANTE 2: SOUTIEN FINANCIER SOUS FORME DE SUBVENTIONS A COUTS PARTAGES <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                    <p>
                      Soutien financier sous forme de subventions à coûts partagés par l’appui aux entreprises détenues ou dirigées par des femmes avec une allocation minimale de 5 000 dollars et une allocation maximale de 15 000 dollars par entreprise bénéficiaire, à investir principalement dans les biens d’immobilisation dont l'entreprise a besoin.
                    </p>
                  </div>
                </li>
                <li data-aos="fade-up" data-aos-delay="200">
                  <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-3" class="collapsed">COMPOSANTE 3 : RESILIENCE DES CHAINES DE VALEURS <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                    <p>
                      Résilience des chaines de valeurs sous forme de soutien aux entreprises leaders et associations/coopératives burkinabè (pas nécessairement détenues/dirigées par une femme) pour la protection et l’amélioration des chaînes de valeur vitales qui auront un impact positif et un effet multiplicateur sur de nombreuses autres MPME (détenues/dirigées par des femmes) de la chaîne, jusqu’à hauteur de 50 000 $US.
                    </p>
                  </div>
                </li>
            </ul>
          </div>

        </div>
      </section>
    <section id="partenaire" class="testimonials">
        <div class="container" data-aos="fade-up">

          <div class="section-title">
              <hr>
            <h2>Nos partenaires</h2>
            <hr>
          </div>
          {{-- <div class="row">
            <div class="col-sm-4 offset-sm-5"> <p class="sponsors_title">Nos Sponsors</p> </div>
          </div> --}}

          <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="testimonial-item">
                      <img src="{{ asset('assets/img/armoirie.png') }}" class="testimonial-img" alt="">
                      <h3>L'Etat du Burkina Faso</h3>
                      <h4>Partenaire</h4>
                    </div>
                  </div>
              <div class="swiper-slide">
                <div class="testimonial-item">
                  <img src="{{ asset('assets/img/MEBF.png') }}" class="testimonial-img" alt="">
                  <h3>MEBF</h3>
                  <h4>Chargé de l'exécution</h4>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="testimonial-item">

                  <img src="{{ asset('assets/img/ICD_logo.png') }}" class="testimonial-img" alt="">
                  <h3>Islamic Corporation for the
                    Development of the Private Sector</h3>
                  <h4>Partenaire techique et financier</h4>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">

                  <img src="{{ asset('assets/img/ISBD.png') }}" class="testimonial-img" alt="">
                  <h3>Banque Islamique de developpement</h3>
                  <h4>Partenaire techique et financier</h4>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">

                  <img src="{{ asset('assets/img/wefi_logo.svg') }}" class="testimonial-img" alt="" height="200px">
                  <h3>Women  Finance Initiative</h3>
                  <h4>Partenaire  et financier</h4>
                </div>
              </div><!-- End testimonial item -->

            <!-- End testimonial item -->

            </div>
            <div class="swiper-pagination"></div>
          </div>
          {{-- <div class="row">
            <div class="col-sm-4 offset-sm-5"> <p class="sponsors_title">Les banques partenaires</p> </div>
          </div>
          <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="testimonial-item">
                  <img src="{{ asset('assets/img/MEBF.png') }}" class="testimonial-img" alt="">
                  <h3>MEBF</h3>
                  <h4>Chargé de l'exécution</h4>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">

                  <img src="{{ asset('assets/img/ICD_logo.png') }}" class="testimonial-img" alt="">
                  <h3>Sara Wilsson</h3>
                  <h4>Designer</h4>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">

                  <img src="{{ asset('assets/img/ISBD.png') }}" class="testimonial-img" alt="">
                  <h3>Jena Karlis</h3>
                  <h4>Store Owner</h4>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">

                  <img src="{{ asset('assets/img/wefi_logo.svg') }}" class="testimonial-img" alt="" height="200px">
                  <h3>Matt Brandon</h3>
                  <h4>Freelancer</h4>
                </div>
              </div><!-- End testimonial item -->

            <!-- End testimonial item -->

            </div>
            <div class="swiper-pagination"></div>
          </div> --}}
        </div>
      </section>
      <section id="contact" class="contact" style="padding-bottom: 80px;">
        <div class="container" data-aos="fade-up">

          <div class="section-title">
            <h2>Nos Contacts</h2>
          </div>

          <div class="row">

            <div class="col-lg-5 d-flex align-items-stretch">
              <div class="info">
                <div class="address">
                    <i class="bi bi-geo-alt"></i>
                    <h4>adresse:</h4>
                    <p>132, Avenue de Lyon 11 BP 379
                        Ouagadougou 11 Burkina Faso</p>
                  </div>
                  <div class="email">
                    <i class="bi bi-envelope"></i>
                    <h4>Email:</h4><p>info@bravewomen.bf</p>
                  </div>

                  <div class="phone">

                    <i class="bi bi-phone"></i>
                    <div>
                        <p>
                           <p> <h4>Boucle du Mouhoun</h4> </p>
                           <p> Direction régionale de la Chambre de Commerce et d’Industrie du Burkina Faso Dédougou,</p>
                           <p>  Tél. : 61 35 25 42 </p>
                          </p>
                    </div>
                    <div>
                        <div>
                            <p>
                               <p> <h4>Centre</h4> </p>
                               <p> Siège de la Maison de l’Entreprise du Burkina Faso Ouagadougo,</p>
                               <p>  Tél. : 70 76 73 74 / 72 47 18 86 </p>
                              </p>
                        </div>
                    </div>
                    <div>
                        <p>
                           <p> <h4>Hauts Bassins</h4> </p>
                           <p> Quartier Koko de Bobo-dioulasso, à 50 m de l’Eglise Saint Vincent de Paul,</p>
                           <p>  Tél. : 76 52 74 00 </p>
                          </p>
                    </div>
                    <div>
                        <p>
                           <p> <h4> Nord </h4> </p>
                           <p> Direction régionale de la Chambre de Commerce et d’Industrie du Burkina Faso
                            Ouahigouya,</p>
                           <p>  Tél. : 70 78 83 12 </p>
                          </p>
                    </div>
                    {{-- <h4>Support:</h4>
                    <p>TEL : (00226) 25 39 80 58/59
                      Mobile: (00226) 70 11 91 87</p> --}}
                  </div>
                {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3897.1746905798136!2d-1.5276091845115265!3d12.371228031112658!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xe2e958953e7552b%3A0x649718ea89d3bfc8!2sMaison%20de%20l&#39;Entreprise%20du%20Burkina!5e0!3m2!1sfr!2sbf!4v1647354695760!5m2!1sfr!2sbf" style="border:0; width: 100%; height: 290px;"allowfullscreen="" loading="lazy"></iframe> --}}
              </div>

            </div>

            <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
              <form action="{{ route("contact") }}" method="post" role="form" class="php-email-form">
                    @csrf
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="nom">Votre nom</label>
                    <input type="text" name="nom" class="form-control" id="nom" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="nom">Votre Numéro de Téléphone</label>
                    <input type="text" name="telephone" class="form-control" id="nom" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="name">Votre Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                  </div>
                <div class="form-group col-md-6">
                    <label for="name">Votre Zone/Region</label>
                    <select id="zone" class="select-select2" data-placeholder="Selectionnez votre zone"  name="region" style="width: 100%;">
                      <option></option>
                      <option value="centre">Centre</option>
                      <option value="nord">Nord</option>
                      <option value="hauts bassin">Hauts bassins</option>
                      <option value="boucle du mouhoun">Boucle du Mouhoun</option>
                  </select>
                </div>
              </div>
                <div class="form-group">
                  <label for="name">Objet</label>
                  <input type="text" class="form-control" name="subject" id="subject" required>
                </div>
                <div class="form-group">
                  <label for="name">Message</label>
                  <textarea class="form-control" name="message" rows="10" required></textarea>
                </div>
                <div class="my-3">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Votre Message a été envoyé avec succès. Merci!</div>
                </div>
                <div class="text-center"><button type="submit">Envoyer Message</button></div>
              </form>
            </div>

          </div>

        </div>
      </section>

</div>
@endsection
