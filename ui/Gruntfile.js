/*global module:true*/

var serveStatic = require('serve-static');
var enableREST = function(req, res, next){
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

  return next();
};
//var proxySnippet = require('grunt-connect-proxy/lib/utils').proxyRequest;
module.exports = function (grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
      ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
    // Task configuration.
    concat: {
      options: {
        banner: '<%= banner %>',
        stripBanners: true
      },
      dist: {
        src: ['src/<%= pkg.name %>.js'],
        dest: 'dist/<%= pkg.name %>.js'
      }
    },
    uglify: {
      options: {
        banner: '<%= banner %>'
      },
      dist: {
        src: '<%= concat.dist.dest %>',
        dest: 'dist/<%= pkg.name %>.min.js'
      }
    },
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        unused: true,
        boss: true,
        eqnull: true,
        browser: true,
        node: true,
        globals: {
          jQuery: true
        }
      },
      gruntfile: {
        src: 'Gruntfile.js'
      },
      lib_test: {
        src: ['src/**/*.js']
      }
    },
    qunit: {
      files: ['test/**/*.html']
    },
    watch: {
      gruntfile: {
        files: ['<%= jshint.gruntfile.src %>', 'index.html'],
        tasks: ['jshint:gruntfile']
      },
      lib_test: {
        files: '<%= jshint.lib_test.src %>',
        // tasks: ['jshint:lib_test', 'qunit']
        tasks: ['concat:dist', 'uglify:dist']
      },
      options: {
        livereload: 9001,
        reload: true
      },
    },
    // we can use this way or after doing livereload to true from above we can manually inject the livereload.js file in the html file which we want to reload after the watch tasks are over.
    // Following method uses two plugins grunt-contrib-connect and connect-livereload. Livreload option in grunt-contrib-connect injects livereload.js file to the given url using connect-livereload.
    connect: {
      svr: {
        options: {
          port: 9000,
          hostname: "localhost",
          base: ["."],
          keepalive: true,
          livereload: 9001,
          // open: true,
          middleware: function(connect, options, middlewares) {
            // middlewares.unshift(connect.use(enableREST));
            return middlewares;
          }
        },
        proxies: [
          // {
          //   context: '/cortex',
          //   host: 'sysblog.local',
          //   port: 8080,
          //   https: false,
          //   xforward: true,
          //   headers: {
          //     "x-custom-added-header": "x-custom-header-value",
          //     'host': 'sysblog.local' // --- same as changeOrigin but this is for newer version. Required
          //   },
          //   hideHeaders: ['x-removed-header']
          //   // changeOrigin: true // required for proxy to work but doesnt work in new version
          // }
        ]
      },
      livereload: {
        options: {
          port: 9000,
          hostname: "localhost",
          base: ["."],
          keepalive: true,
          livereload: 9001,
          middleware: function (connect, options, middlewares) {
            // middlewares.unshift(require('connect-livereload')());
            if(!Array.isArray(options.base)) {
              options.base = [options.base];
            }

            // Setup the proxy
            // middlewares = [require('grunt-connect-proxy/lib/utils').proxyRequest];

            middlewares.unshift(function(req, res, next) {
                res.setHeader('Service-Worker-Allowed', './');
                next();
            });

            // Serve static files.
            options.base.forEach(function (base) {
              middlewares.push(serveStatic(base));
            });

            // Make directory browse-able.
            var directory = options.directory || options.base[options.base.length - 1];
            middlewares.push(serveStatic(directory));

            return middlewares;
          }
        }
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  // grunt.loadNpmTasks('grunt-contrib-qunit');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-connect');
  grunt.loadNpmTasks('grunt-connect-proxy');

  // Default task.
  // grunt.registerTask('default', ['jshint', 'qunit', 'concat', 'uglify', 'connect']);
  grunt.registerTask('default', ['jshint', 'concat', 'uglify']);
  // grunt.registerTask('proxyConnect', ['configureProxies:server', 'connect:svr']);
  grunt.registerTask('proxyConnect', function() {
    grunt.task.run(['configureProxies:svr', 'connect:livereload']);
  });
};