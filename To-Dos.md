Development Infrastructure
--------------------------

- Finish the build system overhaul to use Autotools instead of Ocamlbuild.
  (@bendiken)

Target Architectures & Platforms
--------------------------------

- Validate builds on Mac OS X, FreeBSD, NetBSD, and OpenBSD.
  Amend the platform detection and support configuration in
  [configure.ac](https://github.com/conreality/conreality/blob/master/configure.ac)
  accordingly.
- Work through and document cross-compilation from x86-64 to ARM.
  The Autotools-based build system in principle supports cross compilation.
  This may require changing `AC_CANONICAL_HOST` to `AC_CANONICAL_TARGET`.
  [See the manual](https://www.gnu.org/software/autoconf/manual/autoconf-2.69/html_node/Canonicalizing.html).

Third-Party Dependencies
------------------------

- Add support for the `ioctl(2)` facility in
  [extunix](https://github.com/ygrek/extunix).
  (pull request [#11](https://github.com/ygrek/extunix/pull/11)
  by @bendiken)
- Enhance [Alcotest](https://github.com/mirage/alcotest)'s user-friendliness
  by pushing `Float` matchers, etc, upstream.
- Update [OCaml-Lua](http://ocaml-lua.forge.ocamlcore.org) to use Lua 5.2+
  instead of the current Lua 5.1. Lua 5.2 brings significant enhancements.

Project Evangelism
------------------

- Submit a mentoring organization application to
  [Google Summer of Code](https://developers.google.com/open-source/gsoc/)
  in 2017. According to their
  [timeline](https://developers.google.com/open-source/gsoc/timeline?hl=en),
  mentoring organizations must apply by mid-February.