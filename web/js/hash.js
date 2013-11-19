function pad(n, width, z) {
    z = z || '0';
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

function randomHexNumber() {
    return (Math.floor(Math.random() * 16)).toString(16);
}

function HashGenerator(hash, config) {
    if (!(this instanceof HashGenerator))
        return new HashGenerator(hash, generatedNumber, animatedNumbers);

    var defaultConfig = {
        generatedNumber: 0,
        animatedNumbers: 3,
        speed: 400
    };

    this.config = jQuery.extend(defaultConfig, config || {});
    this.hash = hash;
    this.listeners = [];

    return this;
}

HashGenerator.prototype.start = function () {
    setInterval(this.generateNext.bind(this), this.config.speed);
};

HashGenerator.prototype.generateNext = function () {
    var newAnimatedValue = this.getNextNumber();
    this.hash = this.hash.substr(0, this.config.generatedNumber) + newAnimatedValue + this.hash.substr(this.config.generatedNumber + this.config.animatedNumbers);
    this.notifyListeners();
};

HashGenerator.prototype.getNextNumber = function () {
    var incrementedSubstring = this.hash.substr(this.config.generatedNumber, this.config.animatedNumbers);
    return incrementedSubstring.split('').map(randomHexNumber).join('');
};

HashGenerator.prototype.listen = function (listener) {
    this.listeners.push(listener);
};

HashGenerator.prototype.notifyListeners = function () {
    this.listeners.forEach(function (listener) {
        listener(this.hash);
    }, this);
};


function getGeneratedNumberByTime(now, hashLength) {
    var start = 10 + 10 / 60;
    var end = 20;
    var currentHour = now.getHours() + now.getMinutes() / 60;

    if(currentHour < start)
        return -1;

    return Math.min(hashLength, Math.floor((currentHour - start) / (end - start) * hashLength));
}


$(function () {
    var hashLength = 80;
    var now = window.location.search == "" ? new Date() : new Date("2013-11-18 " + window.location.search.substr(1) + ":00");
    var generatedNumber = getGeneratedNumberByTime(now, hashLength);
    var animatedNumbers = 3;
    var $hashElement = $('#hash');
    var i;
    var $hashLetters = [];
    var hash =  generatedNumber < 0 ? '' : new Array(Math.min(hashLength, generatedNumber + animatedNumbers)).join('.').split('.').map(randomHexNumber).join('');
    hash += new Array(Math.max(0, hashLength - hash.length + 1)).join('-');


    for(i=0; i < hashLength; i++) {
        var $hashLetter = $('<span class="hash-letter">').text(hash[i]);
        $hashElement.append($hashLetter);
        $hashLetters.push($hashLetter);
    }

    if(generatedNumber < 0)
        return;

    var animateChange = function(letter, index) {
        var $hashLetter = $hashLetters[index];
        var position = $hashLetter.position();
        var originalLetter = $hashLetter.text();
        $hashLetter.text(letter).css({opacity: 0, top: -10}).animate({opacity: 1, top: 0}, 200);

        var $letterPlaceholder = $('<span class="letter-placeholder">').css(position).text(originalLetter);
        $hashElement.append($letterPlaceholder);
        $letterPlaceholder.animate({top: 10, opacity: 0}, 200, function(){ $(this).remove(); });
    };

    var generator = new HashGenerator(hash, {generatedNumber: generatedNumber, animatedNumbers: animatedNumbers});
    generator.listen(function (hash) {
        var i;
        for(i=0; i < hashLength; i++) {
            if(hash[i] != $hashLetters[i].text()){
                animateChange(hash[i], i);
            }
        }
    });
    generator.start();
});