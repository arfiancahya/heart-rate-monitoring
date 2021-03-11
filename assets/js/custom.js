/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

"use strict";

function myFunction(x) {
    if (x.matches) { // If media query matches
        var element = document.getElementById("myId");
        element.classList.remove("d-none");
    } else {
        var element = document.getElementById("myId");
        element.classList.add("d-none");
    }
}

var x = window.matchMedia("(max-width: 1024px)")
myFunction(x) // Call listener function at run time
x.addListener(myFunction) // Attach listener function on state changes