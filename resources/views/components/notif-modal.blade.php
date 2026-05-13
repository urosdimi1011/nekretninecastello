<div class="notif-overlay" id="notifOverlay">
    <div class="notif-modal">
        <div class="notif-modal__header">
            <div>
                <h3><i class="ph ph-bell"></i> {{ __('ui.notif_header_naslov') }}</h3>
                <p>{{ __('ui.notif_header_opis') }}</p>
            </div>
            <button class="notif-modal__close" id="closeNotifModal" type="button">&#215;</button>
        </div>

        <div class="notif-modal__body" id="notifFormBody">
            <div class="notif-section">
                <div class="notif-section__title">{{ __('ui.notif_kontakt') }}</div>
                <div class="notif-form-group">
                    <label>{{ __('ui.notif_email_label') }}</label>
                    <input type="email" id="notifEmail"
                        placeholder="{{ __('ui.notif_email_ph') }}">
                    <span class="notif-error" id="emailError"></span>
                </div>
            </div>

            <div class="notif-section">
                <div class="notif-section__title">{{ __('ui.notif_tip_naslov') }}</div>
                <div class="notif-tipovi" id="notifTipovi">
                    @foreach($tipoviNekretnina as $t)
                        @if($t->tip != 'Beograd')
                        <div class="notif-tip-pill" data-id="{{ $t->id }}">
                            {{ $t->tip }}
                        </div>
                        @endif
                    @endforeach
                </div>
                <span class="notif-error" id="tipError"></span>
            </div>

            <div class="notif-section">
                <div class="notif-section__title">{{ __('ui.notif_cena_naslov') }}</div>
                <div class="notif-cena-toggle">
                    <button type="button" class="active" id="notifBtnUkupno">
                        {{ __('ui.notif_ukupno') }}
                    </button>
                    <button type="button" id="notifBtnMetar">
                        {{ __('ui.notif_po_metru') }}
                    </button>
                </div>
                <input type="hidden" id="cenaPoMetru" value="0">

                <div class="notif-row-2">
                    <div class="notif-form-group">
                        <label for="notifCenaMin" id="labelCenaMin">
                            {{ __('ui.notif_min_cena') }}
                        </label>
                        <input type="text" inputmode="numeric" id="notifCenaMin"
                            placeholder="{{ __('ui.notif_min_ph') }}">
                    </div>
                    <div class="notif-form-group">
                        <label for="notifCenaMax" id="labelCenaMax">
                            {{ __('ui.notif_max_cena') }}
                        </label>
                        <input type="text" inputmode="numeric" id="notifCenaMax"
                            placeholder="{{ __('ui.notif_max_ph') }}">
                    </div>
                </div>
                <span class="notif-error" id="cenaError"></span>
            </div>

            <div class="notif-section">
                <div class="notif-section__title">{{ __('ui.notif_kvadratura') }}</div>
                <div class="notif-row-2">
                    <div class="notif-form-group">
                        <label>{{ __('ui.notif_min_m2') }}</label>
                        <input type="number" id="notifKvadMin"
                            placeholder="{{ __('ui.notif_min_m2_ph') }}" min="0">
                    </div>
                    <div class="notif-form-group">
                        <label>{{ __('ui.notif_max_m2') }}</label>
                        <input type="number" id="notifKvadMax"
                            placeholder="{{ __('ui.notif_max_m2_ph') }}" min="0">
                    </div>
                </div>
                <span class="notif-error" id="kvadError"></span>
            </div>

            <div id="notifDinamickiFilteri"></div>
        </div>

        <div class="notif-success" id="notifSuccess" style="display:none;">
            <div class="notif-success__icon">&#10003;</div>
            <h4>{{ __('ui.notif_uspeh_naslov') }}</h4>
            <p>{{ __('ui.notif_uspeh_opis') }}</p>
            <span class="notif-success__hint">
                {{ __('ui.notif_uspeh_hint') }}
            </span>
        </div>

        <div class="notif-modal__footer">
            <button type="button" class="notif-btn-otkazi" id="notifBtnOtkazi">
                {{ __('ui.notif_otkazi') }}
            </button>
            <button type="button" class="notif-btn-prijavi" id="notifBtnPrijavi">
                {{ __('ui.notif_prijavi') }}
                <span class="notif-btn-spinner" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</div>