
document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
    input.addEventListener('input', (e) => {
        e.target.value = e.target.value.slice(0, 1);
        if (e.target.value !== '' && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
            inputs[index - 1].focus();
        }
    });

    input.addEventListener('paste', (e) => {
        const pasteData = e.clipboardData.getData('text').split('');
        pasteData.forEach((value, idx) => {
            if (inputs[index + idx]) {
                inputs[index + idx].value = value.slice(0, 1);
                if (index + idx < inputs.length - 1) {
                    inputs[index + idx + 1].focus();
                }
            }
        });
        e.preventDefault();
    });
})


$('#api_quota').on('change', function() {
    if($(this).val() == "unlimited") {
        $('#total_requests').val(0)
        $('#total_requests').prop("disabled", true)
    }
    else {
        $('#total_requests').val(1500)
        $('#total_requests').prop("disabled", false)
    }
})
$('#extra_secure').on('change', function() {
    if($(this).val() == 0) {
        $('#security_header').prop("disabled", true)
    }
    else {
        $('#security_header').prop("disabled", false)
    }
})

function checkDepositHaveExpiry() {
    if($('#expiry').val() == 0) {
        $('#expiry_days').prop('disabled', true)
    }
    else {
        $('#expiry_days').prop('disabled', false)
    }
}

$('#expiry').on('change', checkDepositHaveExpiry);

$('#generateRefId').on('click', function() {
    let val = generateId("alphanumeric", 15)
    $('#ref_id').val(val)
});
$('#generate_security_header').on('click', function() {
    if($('#security_header').prop('disabled') == false) {
        let val = generateId("alphanumeric2", 15)
        $('#security_header').val(val)
    }
});

function generateId(what, length) {
    return function() {
      let result = '';
      let characters = '';
      
      if (what === 'alphanumeric') {
        characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      }
      else if (what === 'alphanumeric2') {
        characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      }
      else if (what === 'numeric') {
        characters = '0123456789';
      } else if (what === 'alpha') {
        characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
      }
      
      for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
      }
      
      return result
    };
  }



  let currentQrValue;

  $('.showQr').click(function() {
      currentQrValue = $(this).data('link');
      const qrImg = $('.qr-code img');
      qrImg.attr('src', `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${currentQrValue}`);
      $('.qr-code-wrapper').fadeIn();
  });

  $('.closeQr').click(function() {
      $('.qr-code-wrapper').fadeOut();
  });

  $('.downloadQr').click(function() {
    const qrImgSrc = $('.qr-code img').attr('src');
    const a = document.createElement('a');
    a.href = qrImgSrc; // Set the URL of the QR code image
    a.download = 'qr-code.png'; // Set the name of the file
    document.body.appendChild(a); // Append the anchor to the body
    a.click(); // Trigger the download
    document.body.removeChild(a); // Remove the anchor from the body
});
  // Open QR code in a new tab on image click
  $('.qr-code img').click(function() {
      const qrImgSrc = $(this).attr('src');
      window.open(qrImgSrc, '_blank'); // Open the QR code image in a new tab
  });

  // Social media share functionality
  $('.shareFacebook').click(function() {
      const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentQrValue)}`;
      window.open(shareUrl, '_blank');
  });

  $('.shareTwitter').click(function() {
      const shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(currentQrValue)}`;
      window.open(shareUrl, '_blank');
  });

  $('.shareWhatsApp').click(function() {
      const shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(currentQrValue)}`;
      window.open(shareUrl, '_blank');
  });