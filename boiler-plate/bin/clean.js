"use strict";

/**
 * Performs front-end cleanup.
 */
const
    buildFront = require("@khalifahks/build-front"),
    os = require("os");

let i, removableDirs;


removableDirs = [
    __dirname + "/../web-ui/css/",
    __dirname + "/../web-ui/js/"
];

console.log("Cleaning up directories for", process.env.NODE_ENV, "environment on OS", os.platform());

// Delete directories and the files in them recursively.
for (i = 0; i < removableDirs.length; i++) {
    buildFront.removeDir(removableDirs[i]);
}