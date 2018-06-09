require('./bootstrap');
import React from 'react';
import { render } from 'react-dom';
import { Router,IndexRoute, Route, browserHistory } from 'react-router';

import Home from './components/home/Index';
import Master from './components/Master';
import CreateItem from './components/item/CreateItem';
import EditItem from './components/item/EditItem';
import DisplayItem from './components/item/DisplayItem';
import DisplayIndex from './components/category/DisplayIndex';
import DisplayCity from './components/city/DisplayCity';

render(
  <Router history={browserHistory}>
      <Route path="/" component={Master} >  
        <IndexRoute component={ DisplayIndex } />   
        <Route path="/add-item" component={CreateItem} />
        <Route path="/display-item" component={DisplayItem} />
        <Route path="/edit/:id" component={EditItem} />
        <Route path="/category" component={DisplayIndex} />
        <Route path="/content" component={DisplayIndex} />
        <Route path="/job" component={DisplayIndex} />
        <Route path="/location" component={DisplayCity} />
      </Route>
    </Router>,
        document.getElementById('example')
        );