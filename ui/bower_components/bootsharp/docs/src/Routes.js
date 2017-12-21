import React from 'react';
import { IndexRoute, Route } from 'react-router';

import ComponentsPage from './ComponentsPage';
import NotFoundPage from './NotFoundPage';
import Root from './Root';

export default (
  <Route path="/" component={Root}>
    <IndexRoute component={ComponentsPage} />
    <Route path="components.html" component={ComponentsPage} />

    <Route path="*" component={NotFoundPage} />
  </Route>
);
