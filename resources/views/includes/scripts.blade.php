<script>
    function showAlert() {
        const alertBox = document.getElementById('alert');
        alertBox.classList.remove('hidden');
        alertBox.classList.add('block');

        setTimeout(() => {
            alertBox.classList.add('hidden');
        }, 2000);
    }
</script>

@stack('custom-js')
