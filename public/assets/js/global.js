window.dataIndicator = function (object,value)
{

    if(value == 'on')
    {

        object.attr('disabled','disabled');
        object.find('.indicator-label').addClass('d-none');
        object.find('.indicator-progress').removeClass('d-none');

    }else{
        object.removeAttr('disabled');
        object.find('.indicator-label').removeClass('d-none');
        object.find('.indicator-progress').addClass('d-none');
    }

}
window.showErrorsByClass=  function(errors)
{
    $.each(errors, function(index, value) {
        $('.error_'+index).html(value);
    });
}
window.removeFromErrorsByClass = function (form)
{
    var fieldArray = form.serializeArray();
    var fieldNames = fieldArray.map(function(field,index) {

        let regExp = /\(|\)|\[|\]/g;
        let fieldName = field.name;
        let hasBrackets = regExp.test(fieldName)
        if(hasBrackets && fieldName != '_token'){
            $('input[name="'+fieldName+'"]').next().html('')
            fieldName = fieldName.replace(/\(|\)|\[|\]/g, '');
        }else{
            $('.error_'+fieldName).html('');
        }

    });
}
window.removeFromErrorsByObjectByClass = function (objectData) {
    for (let fieldName in objectData) {
        let fieldValue = objectData[fieldName];
        let regExp = /[\(\)\[\]]/g;
        let sanitizedFieldName = fieldName.replace(regExp, '');
        if (sanitizedFieldName !== '_token') {
            $('input[name="' + sanitizedFieldName + '"]').next().html('');
            if(sanitizedFieldName === 'glass_position'){
                $('.error_' + sanitizedFieldName).html('');
            }
        } else {
            $('.error_' + sanitizedFieldName).html('');
        }
    }
};
window.resetWWLookupFormByName = function (objectData) {
    for (let fieldName in objectData) {
        let fieldValue = objectData[fieldName];
        let regExp = /[\(\)\[\]]/g;
        let sanitizedFieldName = fieldName.replace(regExp, '');
        if (sanitizedFieldName == 'glass_position') {
            $('#glass_position_id').val("").change();
        }else{
            $('input[name="' + sanitizedFieldName + '"]').val('');
        }
    }
}
window.preLoader = function (type) {
   if(type === 'on'){
       $('.pre_loader_main').addClass('overlay');
       $('.pre_loader_main').removeClass('d-none');
   }else{
       $('.pre_loader_main').removeClass('overlay');
       $('.pre_loader_main').addClass('d-none');
   }
}

window.reformatDateTimeTo24H = function (inputDateTime) {
    // Create a new Date object from the input
    let date = new Date(inputDateTime);

    // Extract date, month, year, hours, and minutes
    let day = date.getDate().toString().padStart(2, '0');
    let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are 0-based in JS
    let year = date.getFullYear();
    let hours = date.getHours().toString().padStart(2, '0');
    let minutes = date.getMinutes().toString().padStart(2, '0');

    // Format and return the desired date-time string
    return `${day}/${month}/${year} ${hours}:${minutes}`;
}
window.getWhatWindScreenLookupTable = function (data) {
    let dataArray = [];
    dataArray.push(data);
    // Define table header
    let table = `
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Created</th>
                    <th>Class Position</th>
                </tr>
            </thead>
            <tbody class="ww_lookup_ticket_info">
    `;

    // Loop through the data and add table rows
    for (let item of dataArray) {
        let createdAt = reformatDateTimeTo24H(item.createdDateTime);
        table += `
            <tr>
                <td>${item.lookupId}</td>
                <td>${createdAt}</td>
                <td>${item.glassItemDescription}</td>
            </tr>
        `;
    }

    // Close the table tag
    table += `
            </tbody>
        </table>
    `;
    $('.euro_code_log_table').html(table);
    $('.euro_code_log_table').removeClass('d-none');
}
window.removeWhatWindScreenLookupTable = function () {
    $('.euro_code_log_table').html('');
    $('.euro_code_log_table').addClass('d-none');
}
