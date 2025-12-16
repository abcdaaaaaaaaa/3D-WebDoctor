document.getElementById('registerForm').addEventListener('submit', function(event) {
    const info = document.getElementById('information');
    let infoText = info.value;

    infoText = infoText
        .replace(/\b[Bb]en astım'ım\b/g, (m) => m.charAt(0) === 'B' ? 'Hasta astım' : 'hasta astım')
        .replace(/\b[Bb]en astımım\b/g, (m) => m.charAt(0) === 'B' ? 'Hasta astım' : 'hasta astım')
        .replace(/\b[Aa]stım'ım\b/g, (m) => m.charAt(0) === 'A' ? "Astım'ı" : "astım'ı")
        .replace(/\b[Aa]stımım\b/g, (m) => m.charAt(0) === 'A' ? "Astım'ı" : "astım'ı")
        .replace(/\b[Bb]ende\b/g, (m) => m.charAt(0) === 'B' ? 'Hastada' : 'hastada')
        .replace(/\b[Bb]en\b/g, (m) => m.charAt(0) === 'B' ? 'Hasta' : 'hasta')
        .replace(/\b[Bb]iz\b/g, (m) => m.charAt(0) === 'B' ? 'Hasta' : 'hasta');

    const tokens = {};
    let tokenIndex = 0;
    infoText = infoText.replace(/\b([Aa]stım'ı|[Aa]stımı|[Aa]stım)\b/g, (match) => {
        const token = `__ASTIM_TOKEN_${tokenIndex}__`;
        tokens[token] = match;
        tokenIndex++;
        return token;
    });

    infoText = infoText
        .replace(/([a-zçğıöşü]+?)yorum\b/gi, '$1yor')
        .replace(/([a-zçğıöşü]+?)dım\b/gi, '$1dı')
        .replace(/([a-zçğıöşü]+?)dim\b/gi, '$1di')
        .replace(/([a-zçğıöşü]+?)dum\b/gi, '$1du')
        .replace(/([a-zçğıöşü]+?)düm\b/gi, '$1dü')
        .replace(/([a-zçğıöşü]+?)tım\b/gi, '$1tı')
        .replace(/([a-zçğıöşü]+?)tim\b/gi, '$1ti')
        .replace(/([a-zçğıöşü]+?)tum\b/gi, '$1tu')
        .replace(/([a-zçğıöşü]+?)tüm\b/gi, '$1tü')
        .replace(/([a-zçğıöşü]+?)arım\b/gi, '$1ar')
        .replace(/([a-zçğıöşü]+?)erim\b/gi, '$1er')
        .replace(/([a-zçğıöşü]+?)irim\b/gi, '$1ir')
        .replace(/([a-zçğıöşü]+?)ürüm\b/gi, '$1ür')
        .replace(/([a-zçğıöşü]+?)urum\b/gi, '$1ur');

    Object.keys(tokens).forEach(token => {
        const original = tokens[token];
        const regex = new RegExp(token, 'g');
        infoText = infoText.replace(regex, original);
    });

    info.value = infoText.charAt(0).toUpperCase() + infoText.slice(1);
    
    let sentences = infoText.split(/(?<=\.)\s*/);
    info.value = sentences.map(s => s.trim()).join('\n');

    const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    if (checkboxes.length > 0) {
        let additionalInfo = '';
        checkboxes.forEach((checkbox, index) => {
            additionalInfo += checkbox.value;
            if (index < checkboxes.length - 1) additionalInfo += '\n';
        });
        info.value += '\n' + additionalInfo;
    }
});
