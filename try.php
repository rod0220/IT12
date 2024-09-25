<!-- Include jQuery, Bootstrap, and SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.css">

<div class="tab-wizard">
    <h5>Step 1</h5>
    <section>
        <p>Content for Step 1</p>
    </section>
    <h5>Step 2</h5>
    <section>
        <p>Content for Step 2</p>
    </section>
    <h5>Step 3</h5>
    <section>
        <p>Content for Step 3</p>
    </section>
</div>

<script>
$(".tab-wizard").steps({
    headerTag: "h5",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: "Submit"
    },
    onStepChanged: function (event, currentIndex, priorIndex) {
        $('.steps .current').prevAll().addClass('disabled');
    },
    onFinished: function (event, currentIndex) {
        // Use SweetAlert instead of Bootstrap modal
        Swal.fire({
            title: 'Success!',
            text: 'Your form has been submitted.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    }
});
</script>
