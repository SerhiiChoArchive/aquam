<script>
    @if (session('error'))
        M.toast({
            html: "{{ session('error') }}",
            classes: "red darken-2",
            displayLength: 6000,
        })
    @elseif (session('success'))
        M.toast({
            html: "{{ session('success') }}",
            classes: "green darken-2",
            displayLength: 6000,
        })
    @elseif (count($errors) > 0)
        @foreach ($errors->all() as $error)
            M.toast({
                html: "{{ $error }}",
                classes: "red darken-2",
                displayLength: 6000,
            })
        @endforeach
    @endif
</script>
