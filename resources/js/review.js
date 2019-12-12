var ratedIndex = -1, uID = 0;

$(document).ready(function () {
    resetStarColors();

    if (localStorage.getItem('ratedIndex') != null)
        setStars(parseInt(localStorage.getItem('ratedIndex')));

    $('.fa-star').on('click', function () {
        ratedIndex = parseInt($(this).data('index'));
        localStorage.setItem('ratedIndex', ratedIndex);
        saveToTheDB();
    });

    $('.fa-star') .mouseover(function () {
        resetStarColors();
        var currentIndex = parseInt ($(this).data('index'));
        setStars(1)
    });

    $('.fa-star') .mouseleave(function () {
        resetStarColors();

        if (ratedIndex != -1)
            setStars(ratedIndex)
    });
});

function setStars(max) {
    for (let i=0; i <= max; i++)
        $('.fa-star:eq('+i+')').css('color', 'green');
}

function resetStarColors() {
    $('.fa-star').css('color', 'grey');
}
