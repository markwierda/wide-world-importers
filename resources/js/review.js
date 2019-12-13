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

    $('#editReview').on('click', function () {
        editReview(this);
    });

    $('#saveReview').on('click', function () {
        let review = {};
        let urlParams = new URLSearchParams(window.location.search);

        review.description = $('#edit textarea').val();
        review.stars = $('#stars').val();
        review.user_id = this.dataset.user_id;
        review.product_id = urlParams.get('id');

        saveReview(review);
    });

    $('#cancelReview').on('click', function () {
        $('.review').removeClass('d-none');
        $('#edit').addClass('d-none');
    });

    $('#deleteReview').on('click', function () {
        deleteReview(this);
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

function editReview(element) {
    let review = JSON.parse(element.dataset.review);

    $('.review').addClass('d-none');

    setStars(review.stars -1);
    $('#stars').val(review.stars);

    $('#edit').removeClass('d-none');

    $('#edit textarea').val(review.description);

    review.description = $('#edit textarea').val();
    review.stars = $('#stars').val();
}

function saveReview(review) {
    $.ajax({
        type: 'POST',
        url: 'api/updateReview.php',
        data: review,
        success: function() {
            location.reload();
        }
    });
}

function deleteReview(element) {
    let review = JSON.parse(element.dataset.review);

    $.ajax({
        type: 'POST',
        url: 'api/deleteReview.php',
        data: review,
        success: function() {
            location.reload();
        }
    });
}