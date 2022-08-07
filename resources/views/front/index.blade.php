@extends('layouts.front_new')

@section('head_title', '')
@section('head_keywords', $seo->meta_keys)
@section('head_description', '')

@section('styles')
    <style type="text/css">
        /* Hide the list on focus of the input field */
        datalist {
            display: none;
        }
        /* specifically hide the arrow on focus */
        input::-webkit-calendar-picker-indicator {
            display: none;
        }

    </style>
@endsection

@section('content')


    <div id="sp-page-builder" class="sp-page-builder PiepPiep page-7647">


        <div class="page-content">
            <section id="header" class="sppb-section">
                <div class="sppb-row-overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-md-7" id="column-wrap-id-1623675747033">
                            <div id="column-id-1623675747033" class="sppb-column">
                                <div class="sppb-column-addons">
                                    <div id="sppb-addon-wrapper-1623675747036" class="sppb-addon-wrapper">
                                        <div id="sppb-addon-1623675747036" class="clearfix ">
                                            <div class="sppb-addon sppb-addon-text-block text-left "><h1
                                                        class="sppb-addon-title "><span>PiepPiep ordersoftware</span>  voor leveranciers, retailers & hun klanten
                                                </h1>
                                                <div class="sppb-addon-content"><p>Wil je tijd besparen bij het maken van een order en de kans op fouten verminderen? Maak het jezelf en je klanten makkelijker met de ordersoftware van PiepPiep.</p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="sppb-addon-wrapper-1623675747037" class="sppb-addon-wrapper">
                                        <div id="sppb-addon-1623675747037" class="clearfix ">
                                            <div class="sppb-addon sppb-addon-button-group text-left">
                                                <div class="sppb-addon-content nav"><a onclick="myFunction()"
                                                                                       id="btn-1623675747037"
                                                                                       href="/nl/PiepPiep/registreren"
                                                                                       class="nav-link btn btn-blue">Probeer
                                                        30 dagen gratis</a><a onclick="myFunction()" id="btn-1623675747038"
                                                                              href="/nl/PiepPiep/registreren"
                                                                              class="nav-link btn link-blue">of bestel
                                                        direct</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-4" id="column-wrap-id-1623675747043">
                            <div id="column-id-1623675747043" class="sppb-column  hidden-sm hidden-xs">
                                <div class="sppb-column-addons"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="section-id-1623738603432" class="sppb-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12" id="column-wrap-id-1623738603429">
                            <div id="column-id-1623738603429" class="sppb-column force-left">
                                <div class="sppb-column-addons">
                                    <div id="sppb-addon-wrapper-1623738603435" class="sppb-addon-wrapper">
                                        <div id="sppb-addon-1623738603435" class="clearfix ">
                                            <div class="sppb-addon sppb-addon-text-block text-center "><h2
                                                        class="sppb-addon-title ">Makkelijk en snel een offerte opstellen en deze omtoveren in een order,<span
                                                            class="mobile"><br></span> <span>waar & wanneer</span> jij dat wilt
                                                </h2>
                                                <div class="sppb-addon-content"><p>PiepPiep verbindt retailers in de woonbranche met hun klanten en leveranciers. Alle informatie van offerte tot factuur is terug te vinden in je eigen dashboard. Als retailer beschik je over alle actuele producten en prijzen van je leverancier. Zo heb je meer tijd voor je klant en verkoop je nooit meer néé. </p></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="section-id-1623738603409" class="sppb-section full-width bg-beige-20">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12" id="column-wrap-id-1623738603408">
                            <div id="column-id-1623738603408" class="sppb-column ">
                                <div class="sppb-column-addons">
                                    <div id="section-id-1623746996019" class="sppb-section bg-beige-20 full-width">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-5 order-sm-3 order-xs-3"
                                                     id="column-wrap-id-1623746996020">
                                                    <div id="column-id-1623746996020" class="sppb-column extend-left">
                                                        <div class="sppb-column-addons">
                                                            <div id="sppb-addon-wrapper-1623746996011"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623746996011" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-single-image text-center ">
                                                                        <div class="sppb-addon-content">
                                                                            <div class="sppb-addon-single-image-container">
                                                                                <img class="img-responsive lazyload"
                                                                                     data-src="{{asset('assets/images/Dashboard_Pieppiep.png')}}" width="700" height="1100"
                                                                                     src=""
                                                                                     alt="PiepPiep apps"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 order-sm-1 order-xs-1"
                                                     id="column-wrap-id-1623746996023">
                                                    <div id="column-id-1623746996023" class="sppb-column ">
                                                        <div class="sppb-column-addons">
                                                            <div id="sppb-addon-wrapper-1623828553884"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623828553884" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-text-block text-left ">
                                                                        <h3 class="sppb-addon-title ">Betrouwbaar</h3>
                                                                        <div class="sppb-addon-content"><p>Je wilt
                                                                                natuurlijk dat je bestelling in goede
                                                                                handen is. Dan ben je bij ons aan het juiste
                                                                                adres. PiepPiep slaat je data op een
                                                                                veilige manier op in de cloud en maakt
                                                                                real-time backups van je gegevens.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="sppb-addon-wrapper-1623746995951"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623746995951" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-text-block text-left ">
                                                                        <h3 class="sppb-addon-title ">Gemakkelijk</h3>
                                                                        <div class="sppb-addon-content"><p>PiepPiep maakt bestellen écht makkelijk. Het is simpel in gebruik, overal toegankelijk en je hebt geen inkoopkennis nodig. Lastige opties? Daar doen we niet aan - we houden het simpel.</p></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="sppb-addon-wrapper-1623828553887"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623828553887" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-text-block text-left ">
                                                                        <h3 class="sppb-addon-title ">Intuïtief</h3>
                                                                        <div class="sppb-addon-content"><p>Je kunt direct
                                                                                aan de slag met PiepPiep. Ons
                                                                                ordersoftware is ontwikkeld om het
                                                                                orderproces snel, efficient en volledig te maken met 1 druk.
                                                                                Samen met ondernemers, omdat zij
                                                                                weten wat je echt nodig hebt.</p></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div id="sppb-addon-wrapper-1623828553890"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623828553890" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-button-group text-left">
                                                                        <div class="sppb-addon-content nav"><a
                                                                                    onclick="myFunction()"
                                                                                    id="btn-1623828553890"
                                                                                    href="/nl/PiepPiep"
                                                                                    class="nav-link btn btn-blue">Bekijk alle
                                                                                functies</a></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               </section>   
            <!-- <section id="section-id-1623828553997" class="sppb-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3" id="column-wrap-id-1623828553996">
                            <div id="column-id-1623828553996" class="sppb-column  hidden-sm hidden-xs">
                                <div class="sppb-column-addons"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12" id="column-wrap-id-1623828553995">
                            <div id="column-id-1623828553995" class="sppb-column">
                                <div class="sppb-column-addons">
                                    <div id="section-id-1623828553998" class="sppb-section">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12" id="column-wrap-id-1623828553999">
                                                    <div id="column-id-1623828553999" class="sppb-column">
                                                        <div class="sppb-column-addons">
                                                            <div id="sppb-addon-wrapper-1623828553910"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623828553910" class="clearfix ">
                                                                    <div class="sppb-addon sppb-addon-text-block  "><h2
                                                                                class="sppb-addon-title ">Veilig en
                                                                            betrouwbaar</h2>
                                                                        <div class="sppb-addon-content"><p>PiepPiep is
                                                                                .................</p></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4" id="column-wrap-id-1623828554002">
                                                    <div id="column-id-1623828554002" class="sppb-column">
                                                        <div class="sppb-column-addons">
                                                            <div id="sppb-addon-wrapper-1623828553915"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623828553915" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-single-image text-center ">
                                                                        <div class="sppb-addon-content">
                                                                            <div class="sppb-addon-single-image-container">
                                                                                <img class="img-responsive lazyload"
                                                                                     data-src="https://www.PiepPiep.com/images/PiepPiep/logo/logo-ubl-ready.png"
                                                                                     src="/images/misc/placeholder.png"
                                                                                     alt="UBL Ready"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4" id="column-wrap-id-1623828554003">
                                                    <div id="column-id-1623828554003" class="sppb-column">
                                                        <div class="sppb-column-addons">
                                                            <div id="sppb-addon-wrapper-1623828553917"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623828553917" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-single-image text-center ">
                                                                        <div class="sppb-addon-content">
                                                                            <div class="sppb-addon-single-image-container">
                                                                                <img class="img-responsive lazyload"
                                                                                     data-src="https://www.PiepPiep.com/images/PiepPiep/logo/logo-rgs-ready.png"
                                                                                     src="/images/misc/placeholder.png"
                                                                                     alt="RGS Readdy"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4" id="column-wrap-id-1623828554004">
                                                    <div id="column-id-1623828554004" class="sppb-column">
                                                        <div class="sppb-column-addons">
                                                            <div id="sppb-addon-wrapper-1623828553913"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623828553913" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-single-image text-center ">
                                                                        <div class="sppb-addon-content">
                                                                            <div class="sppb-addon-single-image-container">
                                                                                <img class="img-responsive lazyload"
                                                                                     data-src="https://www.PiepPiep.com/images/PiepPiep/logo/logo-zeker-online.png"
                                                                                     src="/images/misc/placeholder.png"
                                                                                     alt="Keurmerk zeker-online"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3" id="column-wrap-id-1623828554014">
                            <div id="column-id-1623828554014" class="sppb-column hidden-sm hidden-xs">
                                <div class="sppb-column-addons"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="section-id-1623746996055" class="sppb-section customers">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12" id="column-wrap-id-1623746996065">
                            <div id="column-id-1623746996065" class="sppb-column">
                                <div class="sppb-column-addons">
                                    <div id="sppb-addon-wrapper-1623746996071" class="sppb-addon-wrapper">
                                        <div id="sppb-addon-1623746996071" class="clearfix ">
                                            <div class="sppb-addon sppb-addon-text-block text-center "><h2
                                                        class="sppb-addon-title ">Meer dan <span>10.000 ondernemers</span>
                                                    gingen je voor</h2>
                                                <div class="sppb-addon-content"><p>Benieuwd waarom zij blij worden van onze
                                                        software? Ze vertellen het je zelf.</p></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" id="column-wrap-id-1623746996056">
                            <div id="column-id-1623746996056" class="sppb-column">
                                <div class="sppb-column-addons">
                                    <div id="section-id-1623996709062" class="sppb-section">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-6" id="column-wrap-id-1623996709063">
                                                    <div id="column-id-1623996709063" class="sppb-column hidden-xs">
                                                        <div class="sppb-column-addons">
                                                            <div id="sppb-addon-wrapper-1623746996082"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623746996082" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-single-image text-center ">
                                                                        <div class="sppb-addon-content">
                                                                            <div class="sppb-addon-single-image-container">
                                                                                <img class="img-responsive lazyload"
                                                                                     data-src="https://www.PiepPiep.com/images/PiepPiep/klantverhalen/koffie.jpg"
                                                                                     src="/images/misc/placeholder.png"
                                                                                     alt="Klantverhaal 1">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-6" id="column-wrap-id-1623996709066">
                                                    <div id="column-id-1623996709066" class="sppb-column">
                                                        <div class="sppb-column-addons">
                                                            <div id="sppb-addon-wrapper-1623746996058"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623746996058" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-text-block text-left ">
                                                                        <h3 class="sppb-addon-title ">Zorgeloos
                                                                            ondernemen!</h3>
                                                                        <div class="sppb-addon-content"><p class="quote">
                                                                            </p>
                                                                            <p class="name">Klant xâ€“ Bedrijf 1
                                                                                Coffee</p></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="sppb-addon-wrapper-1626267733560"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1626267733560" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-button-group text-left">
                                                                        <div class="sppb-addon-content nav"><a
                                                                                    id="btn-1626267733560"
                                                                                    href="/nl/PiepPiep/klantervaringen/the-village-coffee"
                                                                                    class="nav-link btn link-blue">Lees het hele
                                                                                verhaal</a></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" id="column-wrap-id-1623746996059">
                            <div id="column-id-1623746996059" class="sppb-column">
                                <div class="sppb-column-addons">
                                    <div id="section-id-1623996709075" class="sppb-section">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-6" id="column-wrap-id-1623996709076">
                                                    <div id="column-id-1623996709076" class="sppb-column hidden-xs">
                                                        <div class="sppb-column-addons">
                                                            <div id="sppb-addon-wrapper-1623746996097"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623746996097" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-single-image text-center ">
                                                                        <div class="sppb-addon-content">
                                                                            <div class="sppb-addon-single-image-container">
                                                                                <img class="img-responsive lazyload"
                                                                                     data-src="https://www.PiepPiep.com/images/PiepPiep/klantverhalen/Klantverhaal_vloeren.jpg"
                                                                                     src="/images/misc/placeholder.png"
                                                                                     alt="Klantverhaal 2"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-6" id="column-wrap-id-1623996709078">
                                                    <div id="column-id-1623996709078" class="sppb-column">
                                                        <div class="sppb-column-addons">
                                                            <div id="sppb-addon-wrapper-1623746996100"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623746996100" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-text-block text-left ">
                                                                        <h3 class="sppb-addon-title ">Bestelling plaatsen zo gepiept
                                                                            <div class="sppb-addon-content"><p class="quote">
                                                                                    Binnen no time zet je offerte in bestelling om</p>
                                                                                <p class="name">Klant - Bedrijf 2</p></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="sppb-addon-wrapper-1626267733547"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1626267733547" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-button-group text-left">
                                                                        <div class="sppb-addon-content nav"><a
                                                                                    id="btn-1626267733547"
                                                                                    href="/nl/PiepPiep/klantervaringen/naturals-bloemen"
                                                                                    class="nav-link btn link-blue">Lees het hele
                                                                                verhaal</a></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" id="column-wrap-id-1623746996062">
                            <div id="column-id-1623746996062" class="sppb-column">
                                <div class="sppb-column-addons">
                                    <div id="section-id-1623996709082" class="sppb-section">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-6" id="column-wrap-id-1623996709083">
                                                    <div id="column-id-1623996709083" class="sppb-column hidden-xs">
                                                        <div class="sppb-column-addons">
                                                            <div id="sppb-addon-wrapper-1623746996103"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623746996103" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-single-image text-center ">
                                                                        <div class="sppb-addon-content">
                                                                            <div class="sppb-addon-single-image-container">
                                                                                <img class="img-responsive lazyload"
                                                                                     data-src="https://www.PiepPiep.com/images/PiepPiep/klantverhalen/vloer.jpg"
                                                                                     src="/images/misc/placeholder.png"
                                                                                     alt="Klantverhaal 3"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-6" id="column-wrap-id-1623996709085">
                                                    <div id="column-id-1623996709085" class="sppb-column">
                                                        <div class="sppb-column-addons">
                                                            <div id="sppb-addon-wrapper-1623746996106"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1623746996106" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-text-block text-left ">
                                                                        <h3 class="sppb-addon-title ">Klaar voor de toekomst!</h3>
                                                                        <div class="sppb-addon-content"><p class="quote">
                                                                                Alle wijzigingen worden realtime doorgevoerd.
                                                                                Zo beschik je altijd over de juiste informatie en prijzen.</p>
                                                                            <p class="name">Naam - Bedrijf 3</p></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="sppb-addon-wrapper-1626267733542"
                                                                 class="sppb-addon-wrapper">
                                                                <div id="sppb-addon-1626267733542" class="clearfix ">
                                                                    <div
                                                                            class="sppb-addon sppb-addon-button-group text-left">
                                                                        <div class="sppb-addon-content nav"><a
                                                                                    id="btn-1626267733542"
                                                                                    href="/nl/PiepPiep/klantervaringen/unscared-crossfit"
                                                                                    class="nav-link btn link-blue">Lees het hele
                                                                                verhaal</a></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
            <section id="section-id-1623746996115" class="sppb-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2 col-md-1" id="column-wrap-id-1623746996116">
                            <div id="column-id-1623746996116" class="sppb-column">
                                <div class="sppb-column-addons"></div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-10" id="column-wrap-id-1623746996117">
                            <div id="column-id-1623746996117" class="sppb-column bg-navy-20">
                                <div class="sppb-column-addons">
                                    <div id="sppb-addon-wrapper-1623746996118" class="sppb-addon-wrapper">
                                        <div id="sppb-addon-1623746996118" class="clearfix ">
                                            <div class="sppb-addon sppb-addon-text-block text-center "><h2
                                                        class="sppb-addon-title ">Probeer het zelf</h2>
                                                <div class="sppb-addon-content"><p>Wil jij ook minder tijd kwijt zijn aan bestellen
                                                        van goederen? Maak dan nu een account aan en probeer PiepPiep 30
                                                        dagen gratis uit. Je offerte wordt in no time omgezet in een bestelling - Pieppiep zo gepiept!</p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="sppb-addon-wrapper-1623746996126" class="sppb-addon-wrapper">
                                        <div id="sppb-addon-1623746996126" class="clearfix ">
                                            <div class="sppb-addon sppb-addon-button-group text-center">
                                                <div class="sppb-addon-content nav"><a onclick="myFunction()"
                                                                                       id="btn-1623746996126"
                                                                                       href="/nl/PiepPiep/registreren"
                                                                                       class="nav-link btn btn-blue">Probeer
                                                        30 dagen gratis</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-1" id="column-wrap-id-1623746996119">
                            <div id="column-id-1623746996119" class="sppb-column">
                                <div class="sppb-column-addons"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
