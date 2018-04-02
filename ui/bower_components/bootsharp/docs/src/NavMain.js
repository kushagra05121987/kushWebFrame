import React from 'react';
import { Link } from 'react-router';
import Navbar from 'react-bootstrap/lib/Navbar';
import Nav from 'react-bootstrap/lib/Nav';

const NAV_LINKS = {
  'components': {
    link: '/components.html',
    title: 'Components'
  }
};

const NavMain = React.createClass({
  propTypes: {
    activePage: React.PropTypes.string
  },

  render() {
    let links = Object.keys(NAV_LINKS).map(this.renderNavItem).concat([
      <li key="github-link">
        <a href="https://github.com/SSLcom/bootsharp" target="_blank">GitHub</a>
      </li>
    ]);

    return (
      <Navbar staticTop
        componentClass="header"
        className="bs-docs-nav"
        role="banner"
      >
        <Navbar.Header>
          <Navbar.Brand>
            <Link to="/">Bootsharp</Link>
          </Navbar.Brand>
          <Navbar.Toggle />
        </Navbar.Header>
        <Navbar.Collapse className="bs-navbar-collapse">
          <Nav role="navigation" id="top">
            {links}
          </Nav>
        </Navbar.Collapse>
      </Navbar>
    );
  },

  renderNavItem(linkName) {
    let link = NAV_LINKS[linkName];

    return (
        <li className={this.props.activePage === linkName ? 'active' : null} key={linkName}>
          <Link to={link.link}>{link.title}</Link>
        </li>
      );
  }
});

export default NavMain;
