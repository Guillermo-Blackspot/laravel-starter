<script>
    function url(__URL__, __QUERY__){
      let globalUrl = @json(url('/'));
      let params    = (__QUERY__) 
                        ? '?' + (new URLSearchParams(__QUERY__)).toString()
                        : '';
      return globalUrl + __URL__ + params;
    }
</script>