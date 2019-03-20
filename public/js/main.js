const searchFieldValue = document.getElementById('search-field').value;
const founded = document.getElementsByClassName('students-table__cell');

for (let i = 0; i < founded.length; i++) {
    let textNode = founded.item(i).innerHTML;
    founded.item(i).innerHTML = textNode.replace(searchFieldValue, "<span class=\"search__result--painted\">" + repairCase(textNode, searchFieldValue) + "</span>");
}

function repairCase(str, substr) {
    let answer = '';

    if (!substr) {
        return answer;
    }

    let uStr = str.toUpperCase();
    let uSubst = substr.toUpperCase();
    let len = uSubst.length;
    let index = 0;
    let max_score = -1;
    while (true) {
        let result = uStr.indexOf(uSubst, index);
        if (result === -1) {
            break;
        }
        let founded = str.substr(result, len);
        let score = 0;
        for (let i=0; i < substr.length; i++) {
            if (substr[i] === founded[i]) score++;
        }
        if (score > max_score) {
            max_score = score;
            answer = founded;
        }
        index = result + 1;
    }
    return answer;
}