$(document).ready(function () {
    if($('.country-select').length){
        $('.country-select').selectize({
            onFocus: function () {
                $('#search-country-label').addClass('label-up');
            },
            onBlur: function () {
                if($('.selectize-input').hasClass('has-items'))
                {
                    $('.selectize-control').addClass('valid');
                    $('.selectize-control').removeClass('input-error');
                    $('#search-country-label').addClass('label-up');
                }else{
                    $('.selectize-control').removeClass('valid');
                    $('#search-country-label').removeClass('label-up');
                }
            },

        });
    }
});

if($('.comp-card').length) {
    $('.comp-card').each(function (index) {
        var bar = '#bar-' + index,
            progress = $(this).attr('data-percent') / 100;
        var col_to = "#0bc64c";
        if (progress < 0.95 && progress > 0.5) {
            col_to = "#fb9f35";
        } else if (progress < 0.5) {
            col_to = "#f3300c";
        }
        window["bar-" + index] = new ProgressBar.Circle(bar, {
            color: '#fff',
            trailColor: '#f4f4f40',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 10,
            trailWidth: 10,
            easing: 'easeInOut',
            duration: 1400,
            text: {
                autoStyleContainer: false
            },
            from: {color: '#f3300c', width: 10},
            to: {color: col_to, width: 10},
            // Set default step function for all animate calls
            step: function (state, circle) {
                circle.path.setAttribute('stroke', state.color);
                circle.path.setAttribute('stroke-width', state.width);

                var value = Math.round(circle.value() * 100);
                if (value === 0) {
                    circle.setText('');
                } else {
                    circle.setText('<span style="background-color: ' + col_to + '">' + value + '%</span>');
                }

            }
        });

        window["bar-" + index].animate(progress);  // Number from 0.0 to 1.0
    })

    $('.add_serv-total-price').html();
    $('.add_serv-total-price').html(totalPrice());

}
$(".add_serv-checkbox").change(function() {
        $('.add_serv-total-price').html();
        $('.add_serv-total-price').html(totalPrice());
});

function totalPrice() {
    var currency = '$';
    var total = 0;
    $('.add_serv-checkbox').each(function () {
        if(this.checked) {
            total += parseInt($(this).attr('data-price'));
        }
    })
    return currency + total;
}




$('.input-wrapper').on('focus', '.form-control', function(){
    $('label[for="' + $(this).attr('id') + '"]').addClass('label-up');
});

$('.input-wrapper').on('focusout', '.form-control', function(){
    if( !$(this).val() ) {
        $('label[for="' + $(this).attr('id') + '"]').removeClass('label-up');
    }
});


function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.add-photo-block img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#add-photo").change(function() {
    readURL(this);
});


    /* ----- Tel/Country Input Start ----- */
    if($('#user-phone').length) {
// get the country data from the plugin
        var countryData = window.intlTelInputGlobals.getCountryData(),
            input = document.querySelector("#user-phone"),
            addressDropdown = document.querySelector("#user-country");

// init plugin
        var iti = window.intlTelInput(input, {
            initialCountry: "auto",
            separateDialCode: "true",
            geoIpLookup: function (callback) {
                $.get('https://ipinfo.io?token=6d37fef234f9bd', function () {
                }, "jsonp").always(function (resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });


            },
        });

// populate the country dropdown
        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            var optionNode = document.createElement("option");
            optionNode.value = country.iso2;
            var textNode = document.createTextNode(country.name);
            optionNode.appendChild(textNode);
            addressDropdown.appendChild(optionNode);
        }
// set it's initial value
        addressDropdown.value = iti.getSelectedCountryData().iso2;
        $(addressDropdown).addClass('valid');
// listen to the telephone input for changes
        input.addEventListener('countrychange', function (e) {
            addressDropdown.value = iti.getSelectedCountryData().iso2;
        });

// listen to the address dropdown for changes
        addressDropdown.addEventListener('change', function () {
            iti.setCountry(this.value);
        });

    }


function validateForm(form) {
    var fields = form.find($('.form-control'));
    fields.each(function(){
        if (!$(this).val()){
            $(this).removeClass('valid');
            $(this).addClass('input-error');
        }
        else{
            $(this).addClass('valid');
            $(this).removeClass('input-error');
        }
    });
    if($('.selectize-input').length && $('.selectize-input').hasClass('has-items')){
        $('.selectize-control').removeClass('input-error');
        $('.selectize-control').addClass('valid');
        $('.selectize-dropdown').removeClass('input-error');

    }
    if(fields.hasClass('input-error')){
        return false;
    }
    return true;
}

$('form').on('input keyup', '.form-control', function(){

    var _this = $(this);
    var _form = _this.closest('form');


    if (validateForm(_form)){
        _form.find(('.submit')).addClass('valid-button');
    }else{
        _form.find(('.submit')).removeClass('valid-button');
    }

});



    /* ----- Tel/Country Input End ----- */




/* Card Date Start */
var monthNames = [
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
];
var monthNum = 1;
var year = new Date().getFullYear();
var fullYear = year;
year -= 2000;
$('#f_month').append('<option disabled selected hidden value style="display:none;"></option>');
monthNames.forEach(function(month, i, monthNames){
    var zer = '0';
    if (monthNum >= 10){
        zer = '';
    }
    var fOption = '<option value="' + (i+1) + '">'+ zer + (i+1) + '</option>';
    $('#f_month').append(fOption);
    monthNum++;
});
$('#f_year').append('<option disabled selected hidden value></option>');
for (var i = 0; i < 20; i++){
    var fOption = '<option value="' + year + '">' + fullYear + '</option>';
    $('#f_year').append(fOption);
    year ++;
    fullYear ++;
}

var currentMonth = $('select[name="exp_month"]').val(),
    currentYear = $('select[name="exp_year"]').val();
$('#card-date').text(currentMonth + '/' + currentYear);


$(document).on('change', '#f_month, #f_year', function(){
    var currentMonth = $('select[name="exp_month"] option:selected').text(),
        currentYear = $('select[name="exp_year"]').val();

    if(!currentMonth){
        currentMonth = '00'
    }
    if(!currentYear){
        currentYear = '00'
    }

    $('#card-date').text(currentMonth + '/' + currentYear);

});
/* Card Date End */

/*Card init start */
if($('.card-wrapper').length) {
    var card = new Card({
        // a selector or DOM element for the form where users will
        // be entering their information
        form: '.pay-form', // *required*
        // a selector or DOM element for the container
        // where you want the card to appear
        container: '.card-wrapper', // *required*

        formSelectors: {
            numberInput: 'input#card-num', // optional — default input[name="number"]
            cvcInput: 'input#card-cvv', // optional — default input[name="cvc"]
            nameInput: 'input#cardholder_name' // optional - defaults input[name="name"]
        },

        width: 234, // optional — default 350px
        formatting: true, // optional - default true

        // Strings for translation - optional
        messages: {
            validDate: 'valid\ndate', // optional - default 'valid\nthru'
            monthYear: 'mm/yy', // optional - default 'month/year'
        },

        // Default placeholders for rendered fields - optional
        placeholders: {
            number: '•••• •••• •••• ••••',
            name: 'Full Name',
            expiry: '••/••',
            cvc: '•••'
        },

        masks: {
            cardNumber: '' // optional - mask card number
        },

        // if true, will log helpful messages for setting up Card
        debug: false // optional - default false
    });
}
/*card init End*/

$('.add-person').click(function () {

    var row = '<tr class="added-row">';

    if($('.ubo-form input[name="ubo_lname"]').val() && $('.ubo-form input[name="ubo_fname"]').val())   {
        var fullName = $('.ubo-form input[name="ubo_lname"]').val() + ' ' + $('.ubo-form input[name="ubo_fname"]').val();
    }
    var    passport = $('.ubo-form input[name="ubo_passport"]').val(),
        email = $('.ubo-form input[name="ubo_email"]').val(),
        position = $('.ubo-form input[type="checkbox"]').val();
    row += '<td>' + fullName + '</td>';
    row += '<td>' + passport + '</td>';
    row += '<td>' + email + '</td>';
    row += '<td>' + position + '</td>';
    row += '<td class="added-edit"><div class="edit"><img src="../comformo/img/edit.png" width="16" alt=""></div><div class="delete"><span></span><span></span></div></td>';
    row += '</tr>';
    console.log(fullName);
    console.log(passport);
    console.log(email);
    console.log(position);
    if(fullName && passport && email && position){
        console.log('asdsds');
        $('.added-table tbody').append(row);
    }

});

$('.added-table').on('click', '.delete', function () {
    $(this).closest($('.added-row')).remove();
})


$('#ubo_info .popup-submit').click(function (event) {
    event.preventDefault();
    $('#ubo_alert').css('display','block');
});

$(document).mouseup(function (e){ // событие клика по веб-документу
    var div = $("#ubo_alert .modal-content"); // тут указываем ID элемента
    if (!div.is(e.target) // если клик был не по нашему блоку
        && div.has(e.target).length === 0) { // и не по его дочерним элементам
        $('#ubo_alert').hide(); // скрываем его
    }
});

$('input[name="transfer-role"]').click(function () {
    if ($(this).is(':checked')) {
        var form = $(this).attr('data-form');
        $('.i-form').hide();
        $(form).show();
    }
});


