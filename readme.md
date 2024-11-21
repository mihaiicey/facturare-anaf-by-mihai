# Facturare ANAF Plugin

**Contributors**: Mihai Ciufudean (mihaidev.ro / mihai@icey.ro)

**Tags**: ANAF, SmartBill, Facturare, Romanian Billing Fields, WooCommerce, Completare Automată, CUI

**Requires at least**: 5.0

**Tested up to**: 6.3

**Stable tag**: 1.0.0

**License**: GPLv2 or later

**License URI**: https://www.gnu.org/licenses/gpl-2.0.html

---

## Descriere

**Facturare ANAF Plugin** este un plugin WordPress care facilitează completarea automată a câmpurilor de facturare pe baza CUI-ului companiei. Acesta integrează servicii ANAF pentru a obține automat informații despre companie, eliminând necesitatea introducerii manuale a detaliilor de facturare.

Pluginul funcționează cu cele mai populare pluginuri de facturare pentru România:

1. **[Facturare Persoană Fizică sau Juridică](https://wordpress.org/plugins/facturare-persoana-fizica-sau-juridica/)**
2. **[SmartBill - Facturare și Gestiune](https://wordpress.org/plugins/smartbill-facturare-si-gestiune/)**
3. **[Romanian Billing Fields](https://wordpress.org/plugins/romanian-billing-fields/)**

Cu acest plugin, utilizatorii pot selecta modulul de facturare dorit și, în funcție de acesta, pluginul va încărca scriptul corespunzător pentru a completa automat câmpurile de facturare la checkout.

Pluginul utilizează [versiunea 8 a API-ului ANAF](https://static.anaf.ro/static/10/Anaf/Informatii_R/Servicii_web/doc_WS_V8.txt) pentru a obține informațiile de facturare.

## Caracteristici

- Integrare cu API-ul ANAF pentru verificarea automată a CUI-ului și completarea datelor companiei.
- Compatibilitate cu pluginuri de facturare populare pentru România.
- Verificare automată pentru eliminarea prefixului `RO` din CUI, pentru a evita erorile de validare.
- Scripturi JavaScript dedicate pentru completarea câmpurilor de facturare pentru fiecare plugin.
- Completarea automată a detaliilor companiei: numele firmei, numărul de înregistrare, adresa, codul poștal și telefonul.

## Instalare

1. **Upload** plugin-ul în folderul `/wp-content/plugins/` sau instalează-l direct din pagina de administrare WordPress.
2. **Activează** plugin-ul prin meniul `Plugins` din WordPress.
3. Navighează la `Setări` > `Facturare ANAF` pentru a selecta modulul de facturare dorit (SmartBill, Facturare Woo, Romanian Billing Fields).
4. Completează câmpul CUI în pagina de checkout pentru a activa completarea automată.

## Utilizare

1. **Selectează Modulul de Facturare**: Accesează `Setări` > `Facturare ANAF` și selectează pluginul de facturare pe care îl utilizezi.
2. **Introdu CUI-ul**: La checkout, introdu codul CUI (fără prefixul `RO`). Pluginul va interoga automat API-ul ANAF pentru a obține informațiile despre companie și le va completa automat în formularul de facturare.

## Va urma
1. Verificare CUI: În JavaScript, se va implementa o verificare suplimentară pentru a se asigura că CUI-ul introdus este corect. Dacă CUI-ul nu este valid, utilizatorul va fi notificat să verifice și să corecteze informația.

## Întrebări Frecvente

### 1. Ce pluginuri de facturare sunt compatibile?
Pluginul este compatibil cu următoarele pluginuri de facturare:
- Facturare Persoană Fizică sau Juridică
- SmartBill - Facturare și Gestiune
- Romanian Billing Fields

### 2. Ce fac dacă API-ul ANAF este în mentenanță?
Dacă API-ul ANAF este în mentenanță, completarea automată nu va fi disponibilă și vei primi un mesaj în acest sens. Poți încerca din nou mai târziu.

### 3. Pot folosi acest plugin pentru facturare în afara României?
Nu. Acest plugin este destinat exclusiv companiilor din România, care folosesc CUI pentru identificare.

## Changelog

### 1.0.0
- Prima versiune stabilă a pluginului.
- Integrare cu API-ul ANAF pentru completarea automată a câmpurilor de facturare.
- Suport pentru pluginurile de facturare SmartBill, Facturare Woo by Avian, și Romanian Billing Fields.

## Licență
Acest plugin este licențiat sub GPLv2 sau mai târziu. Consultați fișierul `LICENSE` pentru mai multe detalii.

