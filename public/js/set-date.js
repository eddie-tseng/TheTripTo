var datesEnabled = $('#available-date').text().split(',');

$('.date').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    startDate: "today",
    beforeShowDay: function (date) {
        var allDates = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2);
        if (datesEnabled.indexOf(allDates) != -1)
            return true;
        else
            return false;
    }
});

