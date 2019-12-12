let ratedIndex = -1;

$(document).ready(function () {
    resetStarColors();

    setStars(-1);

    $('.fa-star').on('click', function () {
        ratedIndex = parseInt($(this).data('index')) -1;
        $('#stars').val(parseInt($(this).data('index')));
    });

    $('.fa-star') .mouseover(function () {
        resetStarColors();
        let currentIndex = parseInt($(this).data('index')) - 1;
        setStars(currentIndex);
    });

    $('.fa-star') .mouseleave(function () {
        resetStarColors();

        if (ratedIndex !== -1)
            setStars(ratedIndex)
    });
});

function setStars(max) {
    for (let i=0; i <= max; i++) {
        $('.fa-star:eq(' + i + ')').css('color', 'green');
    }
}

function resetStarColors() {
    $('.fa-star').css('color', 'grey');
}
