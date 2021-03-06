jQuery(function ($) {
  'use strict';
  var defaultLogo = $(".dealmaker_logo_url").attr("src");
  let preview = function (input) {
    if (input.files && input.files[0]) {
      let img = '<img src="'+window.URL.createObjectURL(input.files[0])+'">';
      $('#user-logo').html(img);
    }
  };

  $('#dm-logo').on('change', function () {
    if ($(this).val() !== '') {
      $(this).css("border-color", "transparent");
      let imgName = $(this)
        .val()
        .replace(/.*(\/|\\)/, '');
      let exten = imgName.substring(imgName.lastIndexOf('.') + 1);
      let expects = ['jpg', 'jpeg', 'png', 'PNG', 'JPG', 'gif'];

      if (expects.indexOf(exten) == -1) {
        $('#user-logo').children("img").attr("src", defaultLogo)
        $('#dm-logo').val('');
        alert('Invalid Image!');
        return false;
      }
      preview(this);
    } else {
      $('#user-logo').children("img").attr("src", defaultLogo)
    }
  });

  function adjustFontSizes(content, text){
    let textSize = content.css("font-size").replace("px", "");
    
    if(text.length > 0){
      content[0].innerText = text;
    }
    
    if(content[0].clientWidth + 2 >= content[0].parentNode.clientWidth){
      content[0].style.fontSize = `${Number(textSize) - 1.5}px`;
    }
    if(content[0].clientWidth < content[0].parentNode.clientWidth - (content[0].parentNode.clientWidth / 5)){
      if(Number(textSize) < 24){
        content[0].style.fontSize = `${Number(textSize) + 1.5}px`;
      }
    }
  }

  var fname = '';
  var lname = '';
  $("#dm-first-name").on("input", function(){
    $(this).css("border-color", "transparent");
    fname = $(this).val();
    $(".fullname-info-text").children("span.fname-info-text").text(fname);
    adjustFontSizes( $(document).find("span.fname-info-text") , fname);
  });

  $("#dm-last-name").on("input", function(){
    $(this).css("border-color", "transparent");
    lname = $(this).val();
    $(".fullname-info-text").children("span.lname-info-text").text(lname);
    adjustFontSizes( $(document).find("span.lname-info-text") , lname);
  });

  $("#dm-jobtitle").on("input", function(){
    $(this).css("border-color", "transparent");
    $(".jobtitle-info-text").children("span").text($(this).val());
    adjustFontSizes( $(document).find(".jobtitle-info-text").children("span") , $(this).val());
  });

  $("#dm-company").on("input", function(){
    $(this).css("border-color", "transparent");
    $(".company-info-text").children("span").text($(this).val());
    adjustFontSizes( $(document).find(".company-info-text").children("span") , $(this).val());
  });


  $("#deal_maker_download_btn").on("click", function(){
    $(".dm-badge__loading").show();
    setTimeout(() => {
      html2canvas(document.getElementById("dealmaker_badge"), {
        scale: 3,
        dpi: 144 * 2,
        allowTaint: true,
        useCORS: true
      }).then(function (canvas) {
        $(".dm-badge__loading").hide();
        var anchorTag = document.createElement("a");
        document.body.appendChild(anchorTag);
  
        anchorTag.download = "badge-"+(fname.toLowerCase()+"-"+lname.toLowerCase())+".png";
        anchorTag.href = canvas.toDataURL();
        anchorTag.target = '_blank';
        anchorTag.click();
      });
    }, 500);
  });

  $("#deal_maker_generate_btn").on('click', function () {
    let error = false;
    if($("#dm-first-name").val() === ""){
      $("#dm-first-name").css("border-color", "red");
      error = true;
    }
    if($("#dm-last-name").val() === ""){
      $("#dm-last-name").css("border-color", "red");
      error = true;
    }
    if($("#dm-jobtitle").val() === ""){
      $("#dm-jobtitle").css("border-color", "red");
      error = true;
    }
    if($("#dm-company").val() === ""){
      $("#dm-company").css("border-color", "red");
      error = true;
    }

    if(!error){
      $("#informations").html("<p class='alert'>Your DealMaker badge has been created!</p>");
      $(".generated_button").removeClass("none");
    }
  });

});
