<div class="notif-overlay" id="notifOverlay">
    <div class="notif-modal">
        <div class="notif-modal__header">
            <div>
                <h3><i class="ph ph-bell"></i> Obaveštenja o nekretninama</h3>
                <p>Primite mejl kada se pojavi nekretnina po vašim kriterijumima</p>
            </div>
            <button class="notif-modal__close" id="closeNotifModal" type="button">&#215;</button>
        </div>

        <div class="notif-modal__body" id="notifFormBody">
            <div class="notif-section">
                <div class="notif-section__title">Kontakt</div>
                <div class="notif-form-group">
                    <label>Email adresa *</label>
                    <input type="email" id="notifEmail" placeholder="vasa@email.com">
                    <span class="notif-error" id="emailError"></span>
                </div>
            </div>

            <div class="notif-section">
                <div class="notif-section__title">Tip nekretnine *</div>
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
                <div class="notif-section__title">Cena</div>
                <div class="notif-cena-toggle">
                    <button type="button" class="active" id="notifBtnUkupno">€ Ukupno</button>
                    <button type="button" id="notifBtnMetar">€/m² Po metru</button>
                </div>
                <input type="hidden" id="cenaPoMetru" value="0">

                <div class="notif-row-2">
                    <div class="notif-form-group">
                        <label for="notifCenaMin" id="labelCenaMin">Min cena (€)</label>
                        <input type="text" inputmode="numeric" id="notifCenaMin" placeholder="npr. 30000">
                    </div>
                    <div class="notif-form-group">
                        <label for="notifCenaMax" id="labelCenaMax">Max cena (€)</label>
                        <input type="text" inputmode="numeric" id="notifCenaMax" placeholder="npr. 150000">
                    </div>
                </div>
                <span class="notif-error" id="cenaError"></span>
            </div>

            <div class="notif-section">
                <div class="notif-section__title">Kvadratura</div>
                <div class="notif-row-2">
                    <div class="notif-form-group">
                        <label>Min m²</label>
                        <input type="number" id="notifKvadMin" placeholder="npr. 30" min="0">
                    </div>
                    <div class="notif-form-group">
                        <label>Max m²</label>
                        <input type="number" id="notifKvadMax" placeholder="npr. 100" min="0">
                    </div>
                </div>
                <span class="notif-error" id="kvadError"></span>
            </div>

            <div id="notifDinamickiFilteri"></div>
        </div>

        <div class="notif-success" id="notifSuccess" style="display:none;">
            <div class="notif-success__icon">&#10003;</div>
            <h4>Uspešno ste se prijavili!</h4>
            <p>Poslali smo vam verifikacioni mejl. Potvrdite email adresu da aktivirate obaveštenja.</p>
        </div>

        <div class="notif-modal__footer">
            <button type="button" class="notif-btn-otkazi" id="notifBtnOtkazi">Otkaži</button>
            <button type="button" class="notif-btn-prijavi" id="notifBtnPrijavi">
                Prijavi se na obaveštenja
                <span class="notif-btn-spinner" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</div>