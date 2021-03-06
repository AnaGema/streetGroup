$(function(){

    $('.submit-btn').click(function() {

        let formData = new FormData();
        let element = document.getElementsByClassName('csv-file')[0];
        formData.append('file', element.files[0]);

        $.ajax({
            type: 'POST',
            url: 'handler/handler.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(response) {
                $('.upload-container').css('display', 'none');
                $('.upload-button').css('display', 'none');
                $('.csv-content').css('display', 'block');

                let contentList = JSON.parse(response);
                let persons = '';

                $.each(contentList, function (index, element) {
                    persons += getListWithFormat(element);
                });

                $('.csv-content-list').append(persons);
            })
            .fail(function() {
                $('.error-message').css('display', 'block');
            });
    });

    /**
     * Generates the list of people
     * @param data
     * @returns {string}
     */
    function getListWithFormat(data)
    {
        let person = '<li><p>';

        $.each(data, function(index, value) {
            if ($.isPlainObject(value)) {
                $.each(value, function(key, element) {
                    person += key.charAt(0).toUpperCase()+key.slice(1)+': '+element+'<br>';
                });
            } else {
                person += index.charAt(0).toUpperCase()+index.slice(1)+': '+value+'<br>';
            }
        });
        return person + '</p></li>';
    }
});