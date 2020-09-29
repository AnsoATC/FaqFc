# Faq and forum module for etudiant.bj: how to contribute

It's very easy to contribute to this project

1. Fork the project & clone locally.

    - Fork it then run after going to a proper folder
    ---
      git clone  https://github.com/<YOUR_GITHUB>/FaqFc.git

    ---
2. Create an upstream remote and sync your local copy before you branch.
    ---
        cd FaqFC
        git remote add upstream https://github.com/Geek-Unstim/FaqFc.git

    ---
3. Branch for each separate piece of work.
        ---

        git checkout <high_level_branch>
        git pull upstream <high_level_branch> 
        git push origin <high_level_branch>
        git checkout -b <your_working_branch>

        ---

4. Do the work, write good commit messages, and read the CONTRIBUTING file.
    __Note: make sure you're working on your <your_working_branch>__

5. Push to your origin repository.
        ---

        git push -u origin <your_working_branch>

        ---
6. Create a new PR in GitHub.
 __Note: You can do this in your forked repo on github__
 __Note: When pulling request, please chose <high_level_branch> as base branch on the upstream remote url__

7. Respond to any code review feedback.
 __Note: If you don't follow the guidlines in this docs, your PR will not be accepted !__

8. Thank for participating :heart: