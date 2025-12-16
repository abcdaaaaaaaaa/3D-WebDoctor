let sendValue;

window.onload = async function() {
  while (true) {
    pharmacy = prompt("Eczane Adı (örnek: Abcd Eczanesi):");
    if (!pharmacy || pharmacy.trim() === "") {
      alert("Eczane adı boş olamaz.");
      continue;
    }
    try {
      let res = await fetch("verify.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: new URLSearchParams({ pharmacy: pharmacy.trim() })
      });
      let data = await res.json();
      if (data.status === "success") {
        break;
      } else {
        alert(data.message || "Eczane adı doğrulanamadı.");
      }
    } catch {
      alert("Sunucuya bağlanırken hata oluştu.");
    }
  }

  while (true) {
    confirmation = prompt("Onay Kodu (11 haneli):");
    if (!confirmation || !/^\d{11}$/.test(confirmation)) {
      alert("Geçerli bir 11 haneli onay kodu giriniz.");
      continue;
    }
    try {
      let res = await fetch("verify.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: new URLSearchParams({ pharmacy: pharmacy.trim(), confirmation: confirmation })
      });
      let data = await res.json();
      if (data.status === "success") {
        break;
      } else {
        alert(data.message || "Onay kodu doğrulanamadı.");
      }
    } catch {
      alert("Sunucuya bağlanırken hata oluştu.");
    }
  }

  while (true) {
    name2 = prompt("Eczacı Adı:");
    if (name2 && name2.trim() !== "") break;
    alert("Ad boş olamaz.");
  }

  while (true) {
    surname2 = prompt("Eczacı Soyadı:");
    if (surname2 && surname2.trim() !== "") break;
    alert("Soyad boş olamaz.");
  }

  while (true) {
    password = prompt("Eczacı T.C. Kimlik Numarası:");
    if (password && /^\d{11}$/.test(password)) break;
    alert("Geçerli bir 11 haneli T.C. Kimlik Numarası giriniz.");
  }

  pharmacy = pharmacy.trim().split(" ").map(k => k.charAt(0).toUpperCase() + k.slice(1).toLowerCase()).join(" ");
  name2 = name2.trim().split(" ").map(k => k.charAt(0).toUpperCase() + k.slice(1).toLowerCase()).join(" ");
  surname2 = surname2.trim().split(" ").map(k => k.charAt(0).toUpperCase() + k.slice(1).toLowerCase()).join(" ");

  alert("Giriş başarılı.\nEczane: " + pharmacy + "\nEczacı: " + name2 + " " + surname2 + "\nT.C. Kimlik No: " + password + "\nOnay Kodu: " + confirmation);
};

function sendDataToFile(fileName, extraParams = "") {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", fileName, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status == "error") {
                console.error(fileName + " error: " + response.message);
            } else {
                console.log(fileName + " successful: " + response.message);
            }
        }
    };
    var data = "user_id=" + user_id + "&name=" + encodeURIComponent(name) + "&surname=" + encodeURIComponent(surname) + "&information=" + encodeURIComponent(info) + "&ill_id=" + id + "&medicine=" + encodeURIComponent(medicine) + "&conclusion_rationale=" + encodeURIComponent(conclusion_rationale) + "&detail_conclusion_rationale=" + encodeURIComponent(detail_conclusion_rationale) + "&result=" + encodeURIComponent(result) + "&pharmacy=" + encodeURIComponent(pharmacy) + "&confirmation=" + encodeURIComponent(confirmation) + "&name2=" + encodeURIComponent(name2) + "&surname2=" + encodeURIComponent(surname2) + "&password=" + encodeURIComponent(password);
    if (extraParams) { data += "&" + extraParams; }
    xhr.send(data);
}

function confirmAction(message) {
    return confirm(message || "Göndermek istediğinizden emin misiniz?");
}

function toggleVisibility(elementId, show = true) {
    document.getElementById(elementId).classList.toggle('hidden', !show);
}

function sendYes() {
    if (confirmAction()) {
        toggleVisibility('resultContainer', false);
        toggleVisibility('approvalReasonContainer', true);
    }
}

function sendNo() {
    if (confirmAction()) {
        toggleVisibility('resultContainer', false);
        toggleVisibility('detailedRejectionQuestionContainer', true);
    }
}

function detailedRejectionYes() {
    if (confirmAction()) {
        toggleVisibility('detailedRejectionQuestionContainer', false);
        toggleVisibility('detailedRejectionReasonContainer', true);
        sendValue = 0;
    }
}

function detailedRejectionNo() {
    if (confirmAction()) {
        toggleVisibility('detailedRejectionQuestionContainer', false);
        toggleVisibility('rejectionReasonContainer', true);
        sendValue = 1;
    }
}

function sendDetailedRejectionReason() {
    const detailedText = document.getElementById('detailedRejectionText').value.trim();
    if (confirmAction() && detailedText !== "") {
        detail_conclusion_rationale = detailedText;
        alert("Detaylı Red gerekçesi gönderildi.");
        console.log("Detaylı Red Gerekçesi:", detail_conclusion_rationale);
        toggleVisibility('detailedRejectionReasonContainer', false);
        toggleVisibility('rejectionReasonContainerFilled', true);
    } else {
        alert("Lütfen ilgili gerekçeyi doldurunuz.");
    }
}

function sendRejectionReason() {
    if (confirmAction()) {
        const checkedOptions = document.querySelectorAll('input[name="rejectionReason"]:checked');
        if (checkedOptions.length > 0) {
            const selectedReasons = Array.from(checkedOptions).map(option => option.value);
            conclusion_rationale = selectedReasons.join(", ");
            alert("Red gerekçesi gönderildi.");
            console.log("Red Gerekçesi:", conclusion_rationale);
            toggleVisibility('rejectionReasonContainer', false);
            toggleVisibility('resultContainer', false);
            result = '-';
            if (sendValue == 1) { sendDataToFile("save_result.php"); }
        } else {
            alert("Lütfen en az bir red gerekçesi seçin.");
        }
    }
}

function sendRejectionReasonFilled() {
    if (confirmAction()) {
        const selectedReasonsFilled = Array.from(document.querySelectorAll('input[name="rejectionReasonFilled"]:checked'))
            .map(option => option.value);
        conclusion_rationale = selectedReasonsFilled.join(", ");
        alert("Red gerekçesi gönderildi.");
        console.log("Red Gerekçesi (Dolu):", conclusion_rationale);
        toggleVisibility('rejectionReasonContainerFilled', false);
        toggleVisibility('resultContainer', false);
        result = '-';
        sendDataToFile("save_result.php");
    }
}

function sendApprovalReason() {
    if (confirmAction()) {
        const approvalText = document.getElementById('approvalText').value;
        conclusion_rationale = approvalText;
        alert("Kabul gerekçesi gönderildi.");
        console.log("Kabul Gerekçesi:", conclusion_rationale);
        toggleVisibility('approvalReasonContainer', false);
        toggleVisibility('resultContainer', false);
        result = '+';
        sendDataToFile("save_result.php");
    }
}