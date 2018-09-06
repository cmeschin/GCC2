function waiting(){
        $('#spinner').show();
        $this.onreadystatechange = function() {
            $this.preventDefault();
            if ($this.readyState == "complete") {
                $('#spinner').hide();
            } else {
                $('#spinner').show();
            };
        };
}
