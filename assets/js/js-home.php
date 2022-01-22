<script>
    //FORMAT
    function textFormat() {
        let paragraphs = document.getElementsByClassName("paragraph");
        for (let index = 0; index < paragraphs.length; index++) {
            let para = paragraphs[index];
            if (para.innerText.length > 80) {
                para.innerText = para.innerText.substr(0, 80) + "...";
            }
        }
    }

    textFormat();
</script>