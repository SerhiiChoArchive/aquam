<script>
    @if (session('error'))
    M.toast({
        html: "{{ session('error') }}",
        classes: "red darken-2",
    })
    @elseif (session('success'))
    M.toast({
        html: "{{ session('success') }}",
        classes: "green darken-2",
    })
    @endif
</script>
