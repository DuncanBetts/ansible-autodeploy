<pre><?php

// {% if autodeploy_dynamic_deploy_repo_names %}

function ansibleExec(repo) {
  echo shell_exec('/usr/local/bin/ansible-playbook {{ autodeploy_path }}/'.repo.'.yml -i {{ autodeploy_path }}/hosts');
}

// {% endif %}

if($_SERVER['REQUEST_METHOD'] === 'POST') {

//   {% if autodeploy_dynamic_deploy_repo_names %}


  $data = file_get_contents('php://input');
  $post = json_decode($data, TRUE);
  $repo = $post['repository']['slug'];

  switch($repo) {
  // {% for repo in autodeploy_dynamic_deploy_repo_names %}   

    case '{{ repo }}':
      ansibleExec('{{ repo }}');
      break;

  // {% endfor%}

  }

//   {% else %}
  # Set PYTHONUNBUFFERED environment variable, so that the output from ansible isn't buffered
  putenv("PYTHONUNBUFFERED=1");
  echo shell_exec('/usr/local/bin/ansible-playbook {{ autodeploy_path }}/deploy.yml -i {{ autodeploy_path }}/hosts');

//   {% endif %}

}

?></pre>
