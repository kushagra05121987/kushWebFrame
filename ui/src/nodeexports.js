// once module.exports is set exports won't work.
// exports is just helper of module.exports its module.exports that is exposed to the application when required.
// If module.exports is set before or after exports is set then setting things in exports won't work.
function details() {
    this.firstname = "Kushagra";
}
exports.lastname = "Mishra";

module.exports = {exports, details};