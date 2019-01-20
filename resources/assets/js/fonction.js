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

function gccOkNok(){
    // TODO: function to set span OK or span NOK for each elements

}