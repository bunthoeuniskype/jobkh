require('./bootstrap');
import React from 'react';
import { render } from 'react-dom';
import { Router,IndexRoute, Route, browserHistory } from 'react-router';

import Home from './components/home/Index';
import Master from './components/Master';
import CreateItem from './components/item/CreateItem';
import EditItem from './components/item/EditItem';
import DisplayItem from './components/item/DisplayItem';

render(
  <Router history={browserHistory}>
      <Route path="/" component={Master} >  
        <IndexRoute component={ Home } />   
        <Route path="/add-item" component={CreateItem} />
        <Route path="/display-item" component={DisplayItem} />
        <Route path="/edit/:id" component={EditItem} />
      </Route>
    </Router>,
        document.getElementById('example')
        );