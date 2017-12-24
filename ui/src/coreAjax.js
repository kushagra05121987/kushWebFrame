import {upload} from "./upload.js";
import {download} from "./download.js";
export function callXA($) {
    $(document).ready(function() {
        upload($);
        download($);
    });
};


// not all the events will work in synchronous calls but for asynchronous calls all the events will work.