jQuery(document).ready(function($) {
    // Ascultă evenimentul de blur pe câmpul CUI pentru a iniția completarea automată
    $('#smartbill_billing_cif').on('blur', function() {
        let cui = $(this).val();

        // Verificăm dacă CUI-ul începe cu 'RO' și îl eliminăm dacă este cazul
        if (cui.toUpperCase().startsWith('RO')) {
            cui = cui.substring(2).trim();
            $(this).val(cui); // Actualizăm valoarea în câmpul de input fără 'RO'
            alert('Vă rugăm să nu introduceți prefixul RO la CUI. Acesta a fost eliminat automat.');
        }
        if (cui) {
            $.ajax({
                url: anafApiData.restApiUrl + '?cui=' + cui,
                method: 'GET',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', anafApiData.nonce);
                },
                success: function(response) {
                    // Verificăm dacă răspunsul indică o problemă sau mentenanță
                    if (response === false || (response.message && response.message.includes('mentenanță'))) {
                        console.log('Nu s-au găsit date sau serviciul este în mentenanță. Oprire completare automată.');
                        return; // Oprire completare automată
                    }

                    if (response && response.nume) {
                        // Completați automat câmpurile cu datele obținute
                        $('#smartbill_billing_nr_reg_com').val(response.reg_com);
                        $('#smartbill_billing_company_name').val(response.nume);
                        $('#billing_phone').val(response.telefon);
                        $('#billing_address_1').val(response.strada + ', Nr. ' + response.numar);
                        $('#billing_postcode').val(response.cod_postal);
                    } else {
                        console.log('Compania nu a fost găsită.');
                    }
                },
                error: function(error) {
                    console.log('Eroare la apelul API:', error);
                }
            });
        }
    });
});
