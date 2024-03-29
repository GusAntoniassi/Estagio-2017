<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
%>

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $query = $this-><%= $currentModelName %>
            ->find('search', ['search' => $this->request->getQueryParams()])
            <% $belongsTo = $this->Bake->aliasExtractor($modelObj, 'BelongsTo'); %>
            <% if ($belongsTo): %>
->contain([<%= $this->Bake->stringifyList($belongsTo, ['indent' => false]) %>])
            <% endif; %>;

        $this->paginate = ['limit' => 20];
        $<%= $pluralName %> = $this->paginate($query);

        $this->set(compact('<%= $pluralName %>'));
        $this->set('_serialize', ['<%= $pluralName %>']);

        $this->set('crumbs', $this->_crumbs);
    }
