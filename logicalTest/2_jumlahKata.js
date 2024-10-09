function countValidWords(sentence) {
    const words = sentence.split(/\s+/);
    let validWordCount = 0;

    words.forEach(function (word) {
        // Remove valid ending punctuation: period, comma, exclamation mark, question mark
        let cleanedWord = word.replace(/[.,!?]$/, '');

        // Handle hyphenated words by keeping only the first part
        cleanedWord = cleanedWord.split('-')[0];

        // Check if the cleaned word contains only letters
        if (/^[a-zA-Z]+$/.test(cleanedWord)) {
            validWordCount++;
        }
    });

    return validWordCount;
}

console.log(countValidWords("Saat meng*ecat tembok, Agung dib_antu oleh Raihan."));
console.log(countValidWords("Berapa u(mur minimal[ untuk !mengurus ktp?"));
console.log(countValidWords("Masing-masing anak mendap(atkan uang jajan ya=ng be&rbeda."));
