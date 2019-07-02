#!/usr/bin/env bash

echo "Killing supervisor";

while read line; do
  echo "Processing Event: $line" >&2;
  kill -3 $(cat "/var/run/supervisord.pid")
done < /dev/stdin