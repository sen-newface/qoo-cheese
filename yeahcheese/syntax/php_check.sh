#!/bin/bash

if [ -n "$GITHUB_WORKFLOW" ]; then
    LIST=`git diff --name-only --diff-filter=d origin/master...HEAD`

    if [ -z "$LIST" ]; then
        echo "PHP file not changed."
        exit 0
    fi

    PHPCS_ERRORS=`echo $LIST \
    | xargs yeahcheese/vendor/bin/phpcs -n --report=emacs --standard=yeahcheese/syntax/phpcs.rule.xml \
    | tmp/bin/reviewdog -efm="%f:%l:%c: %m" -diff="git diff --diff-filter=d origin/master...HEAD" -reporter=github-pr-review`

    # Todo: PHPMDの結果を標準出力だけでなくreviewdogでもコメントする
    PHPMD_ERRORS=()
    for FILE in $LIST; do
        PHPMD_ERROR=`yeahcheese/vendor/bin/phpmd "$FILE" text yeahcheese/syntax/phpmd.rule.xml`
        if [ -n "$PHPMD_ERROR" ]; then
            PHPMD_ERRORS+=$PHPMD_ERROR
        fi
    done

    if [ -n "$PHPCS_ERRORS" -o -n "$PHPMD_ERRORS"  ]; then
        echo "commented on $GITHUB_REF"
        echo "$PHPCS_ERRORS"
        echo "$PHPMD_ERRORS"
        exit 1
    fi

else
    echo "Here is not GitHub Actions"
fi
exit 0
