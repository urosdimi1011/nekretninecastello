# Castello Nekretnine

Zvanični sajt agencije **Castello Nekretnine Vršac** za pregled ponude nekretnina, kontakt sa agencijom i prijavu na obaveštenja o novim oglasima.

Sajt je namenjen korisnicima koji traže stanove, kuće, lokale, placeve i poljoprivredno zemljište, sa fokusom na preglednu ponudu, brzu pretragu i jednostavan kontakt sa agencijom.

## Pregled

Na sajtu se nalaze:

- početna stranica sa istaknutim nekretninama
- pregled kategorija nekretnina
- detalji pojedinačnih oglasa
- kontakt informacije i društvene mreže agencije
- kreditni kalkulator
- prijava na email obaveštenja za nove nekretnine po zadatim kriterijumima

Prema javno dostupnim informacijama na sajtu, agencija posluje u Vršcu i nudi ponudu za:

- stanove
- kuće
- lokale
- placeve
- poljoprivredno zemljište
- nekretnine u Beogradu

Sajt: [vrsacnekretnine.rs](https://vrsacnekretnine.rs/)

## Ključne funkcionalnosti

- prikaz istaknutih i aktuelnih nekretnina
- filtriranje po tipu nekretnine i atributima oglasa
- prijava korisnika na obaveštenja preko email adrese
- verifikacija pretplate putem email linka
- dinamički filteri u zavisnosti od tipa nekretnine
- osnova za planirano grupno slanje dnevnih email obaveštenja

## Tehnologije

Projekat je razvijan na Laravel osnovi, uz klasičan serverski renderovan frontend.

- PHP / Laravel
- Blade templating
- JavaScript
- HTML / CSS
- MySQL
- SMTP email slanje

## Pokretanje projekta lokalno

1. Klonirati repozitorijum.
2. Instalirati PHP zavisnosti:

```bash
composer install
```

3. Kopirati `.env` fajl:

```bash
cp .env.example .env
```

4. Podesiti konekciju ka bazi i mail parametre u `.env`.
5. Generisati aplikacioni ključ:

```bash
php artisan key:generate
```

6. Pokrenuti migracije:

```bash
php artisan migrate
```

7. Po potrebi pokrenuti seedere:

```bash
php artisan db:seed
```

8. Startovati lokalni server:

```bash
php artisan serve
```

## Email obaveštenja

Sistem podržava pretplatu korisnika na nove oglase prema zadatim kriterijumima. Tok rada je sledeći:

- korisnik unese email i izabere kriterijume
- kreira se pretplata i šalje verifikacioni email
- nakon potvrde email adrese pretplata postaje aktivna
- nove nekretnine se mogu povezivati sa odgovarajućim pretplatama

Ako se koristi pravi SMTP server, potrebno je da `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD` i `MAIL_ENCRYPTION` budu ispravno podešeni u `.env`.

Za lokalno testiranje bez pravog slanja može se koristiti:

```env
MAIL_MAILER=log
```

## Struktura funkcionalnosti

Najvažniji delovi projekta uključuju:

- upravljanje nekretninama
- prikaz i filtriranje oglasa
- pretplatnike i filtere pretplate
- verifikaciju pretplate email porukom
- dinamičke filter definicije po tipu nekretnine

## Napomene

- filteri se mogu prikazivati dinamički u zavisnosti od odabranog tipa nekretnine
- za email verifikaciju potrebno je da named rute budu pravilno definisane
- za produkciju je preporučeno korišćenje queue sistema za slanje mejlova
- dnevni digest obaveštenja je prirodan sledeći korak za unapređenje korisničkog iskustva

## Kontakt

**Castello Nekretnine Vršac**  
Vaska Pope 2, ulaz iz Gavrila Principa  
Telefon: `+381 65 8234 501`  
Email: `castellonekretnine@gmail.com`

## Licenca

Ovaj projekat je vlasništvo agencije Castello Nekretnine, osim ako u repozitorijumu nije drugačije naznačeno.
