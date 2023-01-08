const months = [
    {
        id: 1,
        name: 'Ocak'
    },
    {
        id: 2,
        name: 'Şubat'
    },
    {
        id: 3,
        name: 'Mart'
    },
    {
        id: 4,
        name: 'Nisan'
    },
    {
        id: 5,
        name: 'Mayıs'
    },
    {
        id: 6,
        name: 'Haziran'
    },
    {
        id: 7,
        name: 'Temmuz'
    },
    {
        id: 8,
        name: 'Ağustos'
    },
    {
        id: 9,
        name: 'Eylül'
    },
    {
        id: 10,
        name: 'Ekim'
    },
    {
        id: 11,
        name: 'Kasım'
    },
    {
        id: 12,
        name: 'Aralık'
    }
];

Inputmask({mask: "(999) 999-9999"}).mask(".phoneMask");

Inputmask({mask: "9999 9999 9999 9999"}).mask(".creditCardMask");

Inputmask({
    mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
    greedy: false,
    onBeforePaste: function (pastedValue) {
        pastedValue = pastedValue.toLowerCase();
        return pastedValue.replace("mailto:", "");
    },
    definitions: {
        "*": {
            validator: '[0-9A-Za-z!#$%&"*+/=?^_`{|}~\-]',
            cardinality: 1,
            casing: "lower"
        }
    }
}).mask(".emailMask");

/*
* Disable input type datetime-local and date write
* */
$('input[type="datetime-local"]').on('keydown paste', function (e) {
    e.preventDefault();
});
$('input[type="date"]').on('keydown paste', function (e) {
    e.preventDefault();
});


function initializeMoneyInputMask() {
    Inputmask({
        mask: "*{1,20}.*{2,4}",
        definitions: {
            "*": {
                validator: '[0-9]',
                cardinality: 1,
                casing: "lower"
            },
        },
        placeholder: "0",
    }).mask(".moneyMask");
}

function groupBy(array, key) {
    return array.reduce((result, obj) => {
        (result[obj[key]] = result[obj[key]] || []).push(obj);
        return result;
    }, {});
}

function initializeCurrencyInputMask() {
    Inputmask({
        mask: "*{1,20}.*{8,8}",
        definitions: {
            "*": {
                validator: '[0-9]',
                cardinality: 1,
                casing: "lower"
            },
        },
        placeholder: "0",
    }).mask(".currencyMask");
}

initializeMoneyInputMask();
initializeCurrencyInputMask();

$(".onlyNumber").keypress(function (e) {
    if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
});

$(".decimal").keypress(function (e) {
    if (e.which !== 8 && e.which !== 0 && e.which !== 46 && (e.which < 48 || e.which > 57)) {
        return false;
    }
});

toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

function getNextSaturday(date = new Date()) {
    const dateCopy = new Date(date.getTime());

    if (parseInt(dateCopy.getDay()) === 6) {
        return reformatDatetimeTo_YYYY_MM_DD(dateCopy);
    } else {
        return reformatDatetimeTo_YYYY_MM_DD(
            new Date(
                dateCopy.setDate(
                    dateCopy.getDate() + ((7 - dateCopy.getDay() + 6) % 7 || 6),
                ),
            )
        );
    }
}

function reformatDateForCalendar(date) {
    var formattedDate = new Date(date);
    return formattedDate.getFullYear() + '-' +
        String(formattedDate.getMonth() + 1).padStart(2, '0') + '-' +
        String(formattedDate.getDate()).padStart(2, '0') + 'T' +
        String(formattedDate.getHours()).padStart(2, '0') + ':' +
        String(formattedDate.getMinutes()).padStart(2, '0') + ':00';
}

function reformatDatetime(date) {
    var formattedDate = new Date(date);
    return formattedDate.getFullYear() + '-' +
        String(formattedDate.getMonth() + 1).padStart(2, '0') + '-' +
        String(formattedDate.getDate()).padStart(2, '0') + ' ' +
        String(formattedDate.getHours()).padStart(2, '0') + ':' +
        String(formattedDate.getMinutes()).padStart(2, '0') + ':' +
        String(formattedDate.getSeconds()).padStart(2, '0');
}

function reformatDatetimeForInput(date) {
    var formattedDate = new Date(date);
    return formattedDate.getFullYear() + '-' +
        String(formattedDate.getMonth() + 1).padStart(2, '0') + '-' +
        String(formattedDate.getDate()).padStart(2, '0') + 'T' +
        String(formattedDate.getHours()).padStart(2, '0') + ':' +
        String(formattedDate.getMinutes()).padStart(2, '0');
}

function reformatDatetimeTo_YYYY_MM_DD_WithDot(date) {
    var formattedDate = new Date(date);
    return formattedDate.getFullYear() + '.' +
        String(formattedDate.getMonth() + 1).padStart(2, '0') + '.' +
        String(formattedDate.getDate()).padStart(2, '0');
}

function reformatDatetimeTo_YYYY_MM_DD(date) {
    var formattedDate = new Date(date);
    return formattedDate.getFullYear() + '-' +
        String(formattedDate.getMonth() + 1).padStart(2, '0') + '-' +
        String(formattedDate.getDate()).padStart(2, '0');
}

function reformatDatetimeTo_YYYY_MM(date) {
    var formattedDate = new Date(date);
    return formattedDate.getFullYear() + '-' +
        String(formattedDate.getMonth() + 1).padStart(2, '0');
}

function reformatDatetimeTo_DD_MM_YYYY_WithDot(date) {
    var formattedDate = new Date(date);
    return String(formattedDate.getDate()).padStart(2, '0') + '.' +
        String(formattedDate.getMonth() + 1).padStart(2, '0') + '.' +
        formattedDate.getFullYear();
}

function reformatDatetimeTo_DD_MM_YYYY_HH_ii_WithDot(date) {
    var formattedDate = new Date(date);
    return String(formattedDate.getDate()).padStart(2, '0') + '.' +
        String(formattedDate.getMonth() + 1).padStart(2, '0') + '.' +
        formattedDate.getFullYear() + ', ' +
        String(formattedDate.getHours()).padStart(2, '0') + ':' +
        String(formattedDate.getMinutes()).padStart(2, '0');
}

function reformatDatetimeToDateForHuman(date) {
    var formattedDate = new Date(date);
    return String(formattedDate.getDate()).padStart(2, '0') + ' ' +
        months.find(date => date.id === formattedDate.getMonth() + 1).name + ', ' +
        formattedDate.getFullYear();
}

function reformatDatetimeToDatetimeForHuman(date) {
    var formattedDate = new Date(date);
    return String(formattedDate.getDate()).padStart(2, '0') + ' ' +
        months.find(date => date.id === formattedDate.getMonth() + 1).name + ' ' +
        formattedDate.getFullYear() + ', ' +
        String(formattedDate.getHours()).padStart(2, '0') + ':' +
        String(formattedDate.getMinutes()).padStart(2, '0');
}

function getWeekDayOfDate(date) {
    var formattedDate = new Date(date);
    return parseInt(formattedDate.getDay());
}

function reformatInvoiceNumber(datetime, number) {
    return (new Date(datetime)).getFullYear() + '-' + number.padStart(9, '0');
}

function _calculateAge(birthday) {
    var ageDifMs = Date.now() - birthday.getTime();
    var ageDate = new Date(ageDifMs);
    return Math.abs(ageDate.getUTCFullYear() - 1970);
}

function getDatesInRange(startDate, endDate) {
    const date = new Date(startDate.getTime());
    const dates = [];
    while (date <= endDate) {
        dates.push(new Date(date));
        date.setDate(date.getDate() + 1);
    }
    return dates;
}

function getMinutesBetweenTwoDates(startDate, endDate) {
    var firstDate = new Date(startDate);
    var lastDate = new Date(endDate);

    if (reformatDatetimeTo_YYYY_MM_DD(firstDate) === reformatDatetimeTo_YYYY_MM_DD(lastDate)) {
        calculatedMinutes = (lastDate.getTime() - firstDate.getTime()) / 1000 / 60;
        return calculatedMinutes >= 480 ? 480 : calculatedMinutes;
    } else {
        totalMinutes = 0;
        var dates = getDatesInRange(firstDate, lastDate);
        $.each(dates, function (i, date) {
            if (reformatDatetimeTo_YYYY_MM_DD(firstDate) === reformatDatetimeTo_YYYY_MM_DD(date)) {
                calculatedMinutes = (new Date(reformatDatetimeTo_YYYY_MM_DD(date) + ' 18:00').getTime() - firstDate.getTime()) / 1000 / 60;
                totalMinutes += calculatedMinutes >= 480 ? 480 : calculatedMinutes;
            } else if (reformatDatetimeTo_YYYY_MM_DD(lastDate) === reformatDatetimeTo_YYYY_MM_DD(date)) {
                calculatedMinutes = (lastDate.getTime() - new Date(reformatDatetimeTo_YYYY_MM_DD(date) + ' 09:00').getTime()) / 1000 / 60;
                totalMinutes += calculatedMinutes >= 480 ? 480 : calculatedMinutes;
            } else {
                totalMinutes += 480;
            }
        });
        return totalMinutes;
    }
}

function getMinutesBetweenTwoDatesForOvertime(startDate, endDate) {
    var firstDate = new Date(startDate);
    var lastDate = new Date(endDate);
    return calculatedMinutes = (lastDate.getTime() - firstDate.getTime()) / 1000 / 60;
}

function minutesToString(minutes) {
    var remainingMinutes = minutes % 60;
    var hours = Math.floor(minutes / 60);
    // var remainingHours = hours % 8;
    // var days = Math.floor(hours / 8);

    return `${hours > 0 ? hours + ' Saat ' : ''}${remainingMinutes > 0 ? remainingMinutes + ' Dakika' : ''}`;
    // return days + ' days, ' + remainingHours + ' hours, ' + remainingMinutes + ' minutes';
}

$.sum = function (arr) {
    var r = 0;
    $.each(arr, function (i, v) {
        r += +v;
    });
    return r;
}

function reformatNumberToMoney(number) {
    return parseFloat(number).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")
}

function detectMobile() {
    return !!(navigator.userAgent.match(/Android/i)
        || navigator.userAgent.match(/webOS/i)
        || navigator.userAgent.match(/iPhone/i)
        || navigator.userAgent.match(/BlackBerry/i)
        || navigator.userAgent.match(/Windows Phone/i));
}

function checkScreen() {
    if (detectMobile() || $(window).width() < 950) {
        $('.showIfMobile').show();
        $('.hideIfMobile').hide();
        $('#DashboardQuickActions').hide();
        $('#defaultFooter').hide();
        $('#mobileFooter').show();

        $('#kt_body').swipe({
            swipe: function (event, direction, distance) {
                if (detectMobile() && distance > 150) {
                    if (direction === 'right') {
                        $('#kt_aside_mobile_toggle').trigger('click');
                    }

                    if (direction === 'left' && $('#kt_aside').hasClass('drawer-on')) {
                        $('#kt_aside_mobile_toggle').trigger('click');
                    }
                }
            },
            threshold: 1,
            fingers: 'all',
            allowPageScroll: 'vertical',
        });
    } else {
        $('.showIfMobile').hide();
        $('.hideIfMobile').show();
        $('#DashboardQuickActions').show();
        $('#defaultFooter').show();
        $('#mobileFooter').hide();

    }

    // if (detectMobile()) {
    //     $('#kt_aside_menu_wrapper').removeClass('top-0').addClass('top-25');
    // } else {
    //     $('#kt_aside_menu_wrapper').removeClass('top-25').addClass('top-0');
    // }
}

$(window).resize(function () {
    checkScreen();
});

checkScreen();

$('.modal').on('shown.bs.modal', function () {
    $(this).find('.select2Input').select2({
        dropdownParent: $(this).find('.modal-content')
    });
});
