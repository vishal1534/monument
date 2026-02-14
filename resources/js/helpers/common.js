import {downloadFile} from "./axios";

export const customizeLabel = function(str) {
    // Remove underscore and capitalize first letter of each word
    let i, labels = str.split('_');
    for (i=0; i < labels.length; i++) {
        labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
    }
    return labels.join(' ');
}

export const downloadDocument = function(fileObj){
    let formData = new FormData();
    formData.append('file', fileObj.src);
    downloadFile(formData, (response)=>{
        console.log(response)
    });
}

export const searchForEmptyDate = function(currentDate){

    if (currentDate == '')
    {
        return currentDate = null;
    }
    window.detectChanges = true;
    return currentDate;
}

export const debounce = function(fn, delay) {
    let timeoutID = null;
    return function () {
        clearTimeout(timeoutID);
        let args = arguments;
        let that = this;
        timeoutID = setTimeout(function () {
            fn.apply(that, args);
        }, delay);
    };
};

// export default {
//     customizeLabel,
//     downloadDocument
// }
