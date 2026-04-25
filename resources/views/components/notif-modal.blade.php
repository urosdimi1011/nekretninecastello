<div class="notif-overlay" id="notifOverlay">
    <div class="notif-modal">
        <div class="notif-modal__header">
            <div>
                <h3><i class="ph ph-bell"></i> Obaveštenja o nekretninama</h3>
                <p>Primite mejl kada se pojavi nekretnina po vašim kriterijumima</p>
            </div>
            <button class="notif-modal__close" id="closeNotifModal">&#215;</button>
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
                    <div class="notif-tip-pill"
                        data-id="{{ $t->id }}"
                        data-tip="{{ $t->tip }}">
                        {{ $t->tip }}
                    </div>
                    @endif
                    @endforeach
                </div>
                <span class="notif-error" id="tipError"></span>
                <input type="hidden" id="odabraniTipId">
            </div>

            <div class="notif-section">
                <div class="notif-section__title">Lokacija</div>
                <p class="notif-hint">Možete izabrati više lokacija</p>
                <div class="notif-mesta-grid" id="notifMestaGrid">
                    <div class="notif-loader">Učitavanje lokacija...</div>
                </div>
                <span class="notif-error" id="mestaError"></span>
            </div>

            <div class="notif-section">
                <div class="notif-section__title">Cena *</div>
                <div class="notif-cena-toggle">
                    <button type="button" class="active" id="notifBtnUkupno">&#8364; Ukupno</button>
                    <button type="button" id="notifBtnMetar">&#8364;/m&#178; Po metru</button>
                </div>
                <input type="hidden" id="cenaPoMetru" value="0">
                <div class="notif-row-2">
                    <div class="notif-form-group">
                        <label for="notifCenaMin" id="labelCenaMin">Min cena (€)</label>
                        <input type="number" id="notifCenaMin" placeholder="npr. 30000" min="0">
                    </div>
                    <div class="notif-form-group">
                        <label for="notifCenaMax" id="labelCenaMax">Max cena (€)</label>
                        <input type="number" id="notifCenaMax" placeholder="npr. 150000" min="0">
                    </div>
                </div>
                <span class="notif-error" id="cenaError"></span>
            </div>

            <div class="notif-section">
                <div class="notif-section__title">Kvadratura *</div>
                <div class="notif-row-2">
                    <div class="notif-form-group">
                        <label>Min m&#178;</label>
                        <input type="number" id="notifKvadMin" placeholder="npr. 30" min="0">
                    </div>
                    <div class="notif-form-group">
                        <label>Max m&#178;</label>
                        <input type="number" id="notifKvadMax" placeholder="npr. 100" min="0">
                    </div>
                </div>
                <span class="notif-error" id="kvadError"></span>
            </div>

            <div class="notif-section" id="notifAtributiSekcija" style="display:none;">
                <div class="notif-section__title">Dodatni kriterijumi</div>
                <div class="notif-atributi-grid" id="notifAtributiGrid"></div>
            </div>

        </div>

        <div class="notif-success" id="notifSuccess" style="display:none;">
            <div class="notif-success__icon">&#10003;</div>
            <h4>Uspešno ste se prijavili!</h4>
            <p>Poslali smo vam verifikacioni mejl. Potvrdite email adresu da aktivirate obaveštenja.</p>
        </div>

        <div class="notif-modal__footer">
            <button class="notif-btn-otkazi" id="notifBtnOtkazi">Otkaži</button>
            <button class="notif-btn-prijavi" id="notifBtnPrijavi">
                Prijavi se na obaveštenja
            </button>
        </div>
    </div>
</div>